<?

echo div('attd');

	echo $ren->heading('Přehled docházky');

	// Attendance count for footer
	$attendance = array();
	$row = 0;

	Tag::table(array("class" => 'attendance', 'cellspacing' => 0, 'cellpadding' => 0));
		Tag::thead();
			Tag::tr();
				Tag::th(array("class" => 'name'));

				foreach ($trainings as $t) {
					$attendance[$t->id] = 0;
					Tag::th(array(
						'class' => array('tg', 'tg_'.$t->id, $t->start->getTimestamp() > time() ? 'new':'old'),
						'content' => $ren->format_date($t->start, 'human-date')
					));
				}
			close('tr');
		close('thead');

		Tag::tbody();
			foreach ($members as $member) {
				Tag::tr(array("class" => ($row ++) % 2 ? 'odd':'even'));
					Tag::th(array(
						'class'   => 'name',
						'content' => \Impro\User::link($ren, $member->user),
					));

					foreach ($trainings as $t) {

						$attd      = $member->attd->where(array('id_training' => $t->id))->fetch_one();
						$class     = array('tg', 'tg_'.$t->id);
						$title     = '';
						$availible = $member->id_system_user == $request->user()->id && $t->start->getTimestamp() > time();

						if ($attd instanceof \Impro\Team\Training\Ack) {

							if ($attd->status == \Impro\Team\Training\Ack::NOT_SENT) {
								$status = 'not-sent';
								$title = $locales->trans('intra_team_attd_not_sent');
								$c = '?';
							}

							if ($attd->status == \Impro\Team\Training\Ack::SENT) {
								$status = 'sent';
								$title = $locales->trans('intra_team_attd_sent');
								$c = '.';
							}

							if ($attd->status == \Impro\Team\Training\Ack::RESPONSE_YES) {
								$status = 'yes';
								if ($attd->count > 1) {
									$title = $locales->trans('intra_team_attd_yes_guests', $attd->count);
								} else {
									$title = $locales->trans('intra_team_attd_yes');
								}

								$attendance[$t->id] += $attd->count;
								$c = $attd->count;
							}

							if ($attd->status == \Impro\Team\Training\Ack::RESPONSE_NO) {
								$status = 'no';
								$title = $locales->trans('intra_team_attd_no');
								$c = '-';
							}

							if ($attd->status == \Impro\Team\Training\Ack::RESPONSE_MAYBE) {
								$status = 'maybe';
								$title = $locales->trans('intra_team_attd_maybe');
								$c = '?';
							}
						} else {
							$status = 'no-info';
							$title = $locales->trans('intra_team_attd_no_info');
							$c = '?';
						}

						$count = span('count', $c);

						Tag::td(array(
							'class' => $class,
							'content' => $availible ?
								$ren->link_for('team_training_attd_edit', $count, array(
									'args'  => array($team, $t),
									'class' => array('status', $status),
									'title' => $title,
								)):Stag::div(array(
									"class"   => array('status', $status),
									"content" => $count,
									"title"   => $title
								)),
						));
					}

				close('tr');
			}
		close('tbody');
		Tag::tfoot();
			Tag::tr();
				Tag::th(array("class" => 'name', "content" => $locales->trans('intra_team_attd_total')));

				foreach ($trainings as $t) {
					$count = $attendance[$t->id];
					Tag::th(array(
						'class' => array($count >= 5 ? 'good':'bad', 'tg_'.$t->id),
						'content' => $count,
					));
				}

			close('tr');
		close('tfoot');
	close('table');

close('div');
