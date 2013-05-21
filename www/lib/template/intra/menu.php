<?

echo div('menu_left');
	echo div('menu_profile');
		//~ echo span('avatar', $ren->link_for('intra_profile', $request->user()->avatar->to_html(40, 40)));
		echo span('name', $ren->link_for('intra_profile', $request->user()->get_name()));
		echo span('edit', $ren->link_for('intra_profile_settings', l('intra_profile_edit')));
		echo span('cleaner', '');
	close('div');

	echo menu(array('plain', 'main'));
		foreach ($request->user()->teams as $team) {
			echo li($team->label('/teams/{seoname}/'));
		}
	close('menu');

	echo menu(array('plain', 'main'), array(
		li($ren->label_for($response->url('intra_home'), l('intra_wall'), 'godmode/locations/home', 16)),
		li($ren->label_for($response->url('intra_event_create'), l('impro_event_create_new'), 'godmode/modules/calendar', 16)),
	));

	echo menu(array('plain', 'main'), array(
		li($ren->label_for($response->url('intra_teams'), l('impro_teams'), 'godmode/items/team', 16)),
		li($ren->label_for($response->url('intra_events'),  l('impro_events'), 'godmode/modules/calendar', 16)),
		li($ren->label_for($response->url('intra_discussion'), l('intra_discussion'), 'impro/objects/discussion', 16)),
		//~ li($ren->label_for('impro/objects/wiki', 16, '/wiki/', l('intra_wiki'))));
		//~ Tag::li(array("content" => label_for('impro/actions/download', 16, '/files/', l('intra_file_share'))));
	));

	$ren->slot('secondary_menu');

close('div');
