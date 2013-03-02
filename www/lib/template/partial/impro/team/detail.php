<?

Tag::div(array("class" => 'team_detail'));

	$hq = $team->hq ? Stag::div(array("class" => 'map', "content" => $team->hq->map_html(330, 300))):'';

	Tag::div(array(
		"class"   => 'header',
		"content" => array(
			Stag::div(array(
				"class"   => 'team_heading',
				"content" => array(
					Stag::div(array(
						"class" => 'team_logo',
						"content" => link_for(Stag::img(array("src" => $team->logo->thumb(165, 140))), $team->logo->get_path()),
					)),

					Stag::div(array(
						"class" => 'name',
						"content" => array(
							section_heading($team->name),
							heading($team->name_full),
						)
					))
				)
			)),
			Stag::div(array("class" => 'img', "content" =>
				link_for(Stag::img(array("src" => $team->photo->thumb(600, 300), "alt" => $team->get_name())), $team->photo->get_path())
			)),
			$hq,
			Stag::div(array("class" => 'cleaner', 'close' => true)),
	)));


	Tag::div(array("class" => 'team_desc desc', "content" => $team->about));

Tag::close('div');
