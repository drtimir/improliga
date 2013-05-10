<?

Tag::div(array("class" => 'team_detail'));

	$hq = $team->hq ? div('map', array(
		$team->hq->map_html(300, 300),
		div('playground', array(
			heading('Domácí hřiště', false, 3),
			div('location', array(
				Stag::strong(array("content" => $team->hq->name)),
				Stag::br(),
				span('addr', $team->hq->addr),
			)),
		)),
	)):'';

	echo div('header', array(
		div('team_heading', array(
			div('team_logo', link_for($team->logo->to_html(188, 165), $team->logo->get_path(), array("class" => 'fancybox'))),
			div('name', array(
				section_heading($team->name),
				heading($team->name_full),
			))
		)),
		div('img', link_for($team->photo->to_html(600, 300), $team->photo->get_path(), array("class" => 'fancybox'))),
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
