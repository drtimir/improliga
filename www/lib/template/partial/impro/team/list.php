<?

Tag::div(array("class" => 'team_list'));

	Tag::ul();

		foreach ($teams as $team) {
			Tag::li();
				echo link_for(Stag::img(array("src" => $team->logo->thumb(120, 80), "alt" => $team->name)), soprintf($link_team, $team));

				Tag::div(array("class" => "desc", "content" => array(
					Stag::strong(array("content" => link_for($team->name, soprintf($link_team, $team)))),
					Stag::div(array("class" => 'name_full', "content" => $team->name_full)),
					Stag::div(array("class" => 'city', "content" => $team->city)),
				)));

			Tag::close('li');
		}

	Tag::close('ul');
	Tag::div(array("class" => 'cleaner', "close" => true));
Tag::close('div');
