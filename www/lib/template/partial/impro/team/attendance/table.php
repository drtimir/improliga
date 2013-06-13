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
						'content' => $ren->link_for('team_training', $ren->format_date($t->start, 'human-date'), args($team, $t)),
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
						$status    = \Impro\Team\Training\Ack::get_status_class($ren, $attd);
						$count     = span('count', $status['c']);

						if ($attd instanceof \Impro\Team\Training\Ack && $attd->status == \Impro\Team\Training\Ack::RESPONSE_YES) {
							$attendance[$t->id] += $attd->count;
						}

						Tag::td(array(
							'class' => $class,
							'content' => $availible ?
								$ren->link_for('team_training_attd_edit', $count, array(
									'args'  => array($team, $t),
									'class' => array('status', $status['status']),
									'title' => $status['title'],
								)):Stag::div(array(
									"class"   => array('status', $status['status']),
									"content" => $count,
									"title"   => $status['title']
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
