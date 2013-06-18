<?

echo div('menu_left');
	$profile_class = strpos($request->path, '/profile') === 0 ? 'active':'inactive';

	echo div('menu_profile '.$profile_class);
		echo span('avatar', $ren->link_for('profile', $request->user()->avatar->to_html($ren, 40, 40)));
		echo span('name', $ren->link_for('profile', $request->user()->get_name()));
		echo span('edit', $ren->link_for('profile_settings', $locales->trans('intra_profile_edit')));
		echo span('cleaner', '');
	close('div');

	if (count($request->user()->teams)) {
		echo menu(array('plain', 'main'));
			foreach ($request->user()->teams as $team) {
				echo li($team->label($ren));
			}
		close('menu');
	}

	echo menu(array('plain', 'main'), array(
		li($ren->label_for($response->url('home'), $locales->trans('intra_wall'), 'godmode/locations/home', 16)),
		li($ren->label_for($response->url('profile_events'), $locales->trans('intra_events_my'), 'godmode/modules/calendar', 16)),
	));

	echo menu(array('plain', 'main'), array(
		li($ren->label_for($response->url('teams'), $locales->trans('impro_teams'), 'godmode/items/team', 16)),
		li($ren->label_for($response->url('contacts'), $locales->trans('intra_people'), 'impro/contact/email', 16)),
		li($ren->label_for($response->url('events'),  $locales->trans('impro_events'), 'godmode/modules/calendar', 16)),
		li($ren->label_for($response->url('discussion'), $locales->trans('intra_discussion'), 'impro/objects/discussion', 16)),
		li($ren->label_for($response->url('wiki'), $locales->trans('intra_wiki'), 'impro/objects/wiki', 16)),
		li($ren->label_for($response->url('files'), $locales->trans('intra_files'), 'impro/objects/share', 16)),
	));

	$ren->slot('secondary_menu');

close('div');
