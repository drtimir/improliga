<?

echo div('team_list');

	echo $renderer->heading(l('title_impro_teams'));
	echo ul('plain cities');

		foreach ($cities as $city=>$teams) {
			Tag::li();
			echo $renderer->heading_static($city);

			echo ul('plain teams');
				foreach ($teams as $team) {
					$url = $ren->url($link_team, array($team->get_seoname()));
					echo li(array(
						$ren->link($url, $team->logo->to_html(118, 100)),
						div("desc", array(
							Stag::strong(array("content" => $ren->link($url, $team->name))),
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
