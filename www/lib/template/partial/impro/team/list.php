<?

echo div('team_list');

	echo $renderer->heading(l('title_impro_teams'));
	echo ul('plain cities');

		foreach ($cities as $city=>$teams) {
			Tag::li();
			echo $renderer->heading_static($city);

			echo ul('plain teams');
				foreach ($teams as $team) {
					echo li(array(
						link_for($team->logo->to_html(118, 100), soprintf($link_team, $team)),
						div("desc", array(
							Stag::strong(array("content" => link_for($team->name, soprintf($link_team, $team)))),
							div('name_full', $team->name_full),
							div('city', $team->city),
						)),
					));
				}
				close('ul');
			close('li');
		}

	close('ul');
	echo span('cleaner', '');
close('div');
