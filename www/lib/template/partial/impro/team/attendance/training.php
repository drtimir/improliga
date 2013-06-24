<?

echo div(array('training', $training->canceled ? 'off':'on'));

	if ($training->canceled) {
		echo div('tg-warning', $ren->heading_static($locales->trans('training_canceled')));
	}

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ORGANIZE)) {
		echo div('controls', array(
			$ren->label_for_url('team_training_edit', $locales->trans('training_edit'), 'godmode/actions/edit', 16, args($team, $training)),
			$ren->label_for_url('team_training_cancel', $locales->trans('training_cancel'), 'godmode/actions/delete', 16, args($team, $training)),
		));
	}

	echo div('inner');
		echo $ren->heading(sprintf('%s (%s)', $training->name, $ren->format_date($training->start, 'human-date')));

		$content = array();
		$content[] = li(array(
				span('label', $ren->trans('training_date').': '),
				span('value', $ren->format_date($training->start, 'human-full-date')),
			), 'iconed date');
		$content[] = li(array(
				span('label', $ren->trans('training_start').': '),
				span('value', $ren->format_date($training->start, 'human-time').' ('.\Helper\Date::imprecise($ren, $training->start).')')
			), 'iconed time');
		$content[] = li(array(
				span('label', $ren->trans('training_trainer').': '),
				span('value', \Impro\User::link($ren, $training->author)),
			), 'iconed leader');

		if ($training->location) {
			$content[] = li(div('loc', array(
				span('name', $ren->link_ext($training->location->map_link(), $training->location->name)),
				span('addr', $training->location->addr),
				span('site', $ren->link($training->location->site, $training->location->site)),
			)), 'iconed location');
		}

		$content[] = li(array(
			$training->desc ?
				to_html($ren, $training->desc):
				Stag::p(array("content" => $locales->trans('training_no_desc')))
			), 'desc');

		echo ul('plain info', $content);

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

		echo span('cleaner', '');
	close('div');
close('div');
