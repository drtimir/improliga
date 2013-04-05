<?

Tag::div(array("class" => 'team_detail'));

	echo div('header', array(
		div('gallery', array(
			div('team_logo', link_for(Stag::img(array("src" => $team->logo->thumb_trans(210, 210))), $team->logo->get_path())),
			div('img', link_for(Stag::img(array("src" => $team->photo->thumb(370, 210), "alt" => $team->get_name())), $team->photo->get_path())),
			$team->hq ?
				div('map', array(
					$team->hq->map_html(210, 210),
					div('playground label', link_for(
						div('inner', array(
							heading('Domácí hřiště', false, 3),
							div('location', array(
								Stag::strong(array("content" => $team->hq->name)),
								Stag::br(),
								span('addr', $team->hq->addr),
							)),
						)),
						$team->hq->map_link()
					)),
				)):'',
			div('cleaner', ''),
		)),
		div('menu', array(
			div('name', section_heading($team->to_html_link($link_team))),
			ul('options', array(
				Stag::li(array("content" => link_for(l('intra_team_home')))),
				Stag::li(array("content" => link_for(l('intra_team_info')))),
				Stag::li(array("content" => link_for(l('intra_team_events')))),
			)),
		)),
		div('cleaner', ''),
	));


	Tag::div(array("class" => 'cleaner', 'close' => true));
close('div');
