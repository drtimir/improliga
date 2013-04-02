<?

Tag::div(array("class" => 'team_detail'));

	$hq = $team->hq ? Stag::div(array("class" => 'map', "content" => array(
		$team->hq->map_html(300, 300),
		Stag::div(array(
			"class" => 'playground',
			"content" => array(
				heading('Domácí hřiště', false, 3),
				Stag::div(array("class" => 'location', "content" => array(
					Stag::strong(array("content" => $team->hq->name)),
					Stag::br(),
					Stag::span(array("class" => 'addr',"content" => $team->hq->addr)),
				))),
			)
		)),
	))):'';

	echo div('header', array(
		div('team_heading', array(
			div('team_logo', link_for(Stag::img(array("src" => $team->logo->thumb(188, 165))), $team->logo->get_path())),
			div('name', array(
				section_heading($team->name),
				heading($team->name_full),
			))
		)),
		div('img', link_for(Stag::img(array("src" => $team->photo->thumb(600, 300), "alt" => $team->get_name())), $team->photo->get_path())),
		$hq,
		Stag::div(array("class" => 'cleaner', 'close' => true)),
	));

	$info = array();

	if ($team->city) {
		$info[] = Stag::li(array("class" => 'icon city', "content" => $team->city));
	}

	if ($team->site) {
		$info[] = Stag::li(array("class" => 'icon site', "content" => link_for($team->site, $team->site)));
	}

	echo div('left', array(
		Stag::ul(array("content" => $info, "class" => 'info plain team_info')),
		div('team_desc desc', $team->about),
	));

	echo div('right');
		echo heading(l('impro_team_events'));

		//~ if (any($events)) {
			slot('events');
		//~ }

	close('div');

	Tag::div(array("class" => 'cleaner', 'close' => true));
close('div');
