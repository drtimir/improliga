<?

echo div('attd');
	echo $ren->heading($locales->trans('intra_team_attendance'));

	echo div('controls', array(
		$ren->label_for_url('team_training_create', $locales->trans('intra_team_training_create'), 'godmode/actions/create', 16, args($team)),
	));

	if ($latest) {
		Tag::p(array(
			"content" => $locales->trans(
				'intra_team_upcoming_tg',
				$ren->format_date($latest->start, 'human-date'),
				$ren->format_date($latest->start, 'human-time'),
				$latest->location ? $locales->trans('intra_team_tg_loc', $latest->location->name):$locales->trans('intra_team_tg_loc_usual'),
				$locales->trans($latest->open ? 'intra_tg_open':'intra_tg_closed')
			)
		));
	} else Tag::p(array("content" => $locales->trans('intra_team_no_upcoming_trainings')));
close('div');
