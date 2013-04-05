<?

Tag::div(array("class" => 'team_detail'));

	$hq = $team->hq ? div('map', array(
		$team->hq->map_html(210, 210),
		Stag::div(array(
			"class" => 'playground label',
			"content" => link_for(div('inner', array(
				heading('Domácí hřiště', false, 3),
				div('location', array(
					Stag::strong(array("content" => $team->hq->name)),
					Stag::br(),
					span('addr', $team->hq->addr),
				)),
			)), $team->hq->map_link())
		)),
	)):'';

	echo div('header', array(
		div('gallery', array(
			div('team_logo', link_for(Stag::img(array("src" => $team->logo->thumb_trans(210, 210))), $team->logo->get_path())),
			div('img', link_for(Stag::img(array("src" => $team->photo->thumb(370, 210), "alt" => $team->get_name())), $team->photo->get_path())),
			$hq,
		)),
		div('cleaner', ''),
		div('name', array(
			section_heading($team->name),
			heading($team->name_full),
		)),
		div('cleaner', ''),
	));


	Tag::div(array("class" => 'cleaner', 'close' => true));
close('div');
