<?

Tag::div(array("class" => 'menu_left'));
	Tag::div(array("class" => 'menu_profile'));
		Tag::span(array(
			"class" => 'avatar',
			"content" => link_for(Tag::img(array("output" => false, "src" => user()->avatar->thumb(40, 40), "alt" => '')), '/profile/')
		));

		Tag::span(array("class" => 'name', "content" => link_for(user()->get_name(), '/profile/')));
		Tag::span(array("class" => 'edit', "content" => link_for(l('intra_profile_edit'), '/settings/')));
		Tag::span(array("class" => 'cleaner', "close" => true));
	Tag::close('div');

	Tag::menu(array("class" => array('plain', 'main')));
		Tag::li(array("content" => label_for('godmode/locations/home', 16, '/', l('intra_wall'))));
		Tag::li(array("content" => label_for('godmode/items/team', 16, '/teams/', l('impro_teams'))));
		Tag::li(array("content" => label_for('godmode/modules/calendar', 16, '/events/', l('impro_events'))));
		Tag::li(array("content" => label_for('impro/objects/discussion', 16, '/discussion/', l('intra_discussion'))));
		Tag::li(array("content" => label_for('impro/actions/download', 16, '/files/', l('intra_file_share'))));
	Tag::close('menu');

	Tag::menu(array("class" => array('plain', 'main')));
		Tag::li(array("content" => label_for('godmode/modules/calendar', 16, '/profile/events/', l('impro_event_list_my'))));
		Tag::li(array("content" => label_for('godmode/modules/calendar', 16, '/events/create/', l('impro_event_create_new'))));
	Tag::close('menu');

	Tag::menu(array("class" => array('plain', 'main')));
		foreach (user()->teams as $team) {
			Tag::li(array("content" => $team->label('/teams/{seoname}/')));
		}

	Tag::close('menu');
	slot('secondary_menu');

Tag::close('div');
