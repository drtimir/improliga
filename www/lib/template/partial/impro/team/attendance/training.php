<?

echo div('training');

	echo $ren->heading(sprintf('%s (%s)', $training->name, $ren->format_date($training->start, 'human-date')));

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ORGANIZE)) {
		echo div('controls', array(
			$ren->label_for_url('team_training_edit', $locales->trans('intra_team_training_edit'), 'godmode/actions/edit', 16, args($team, $training)),
			$ren->label_for_url('team_training_drop', $locales->trans('intra_team_training_drop'), 'godmode/actions/delete', 16, args($team, $training)),
		));
	}

	$content = array();
	$content[] = li('Datum: '.$ren->format_date($training->start, 'human-date'));
	$content[] = li('Začátek: '.$ren->format_date($training->start, 'human-time'));
	$content[] = li('Vede: '.\Impro\User::link($ren, $training->author));

	if ($training->location) {
		$content[] = li(array(
			span('name', $ren->link_ext($training->location->map_link(), $training->location->name)),
			span('addr', $training->location->addr),
			span('site', $ren->link($training->location->site, $training->location->site)),
		), 'location');
	}

	$content[] = li(array(
		$training->desc ?
			to_html($ren, $training->desc):
			Stag::p(array("content" => $locales->trans('intra_team_training_no_desc')))
		), 'desc');

	echo ul('info', $content);

	echo $ren->heading('Účast');
	echo ul('plain attd-list');
		foreach ($acks as $ack) {
			$status = \Impro\Team\Training\Ack::get_status_class($ren, $ack);

			echo li(array(
				div('l', \Impro\User::avatar($ren, $ack->member->user)),
				div('r', array(
					\Impro\User::link($ren, $ack->member->user),
					div('status', $ack->get_status_name($ren))
				)),
				span('cleaner', ''),
			), $status['status']);
		}

	close('ul');
close('div');
