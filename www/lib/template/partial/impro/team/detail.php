<?

echo div('team_detail');

	$hq = $team->hq ? div('map', array(
		$team->hq->map_html(300, 300),
		div('playground', array(
			$renderer->heading_static('Domácí hřiště', 3),
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
				$renderer->heading($team->name, 1),
				$renderer->heading($team->name_full),
			))
		)),
		div('img', link_for($team->photo->to_html(600, 300), $team->photo->get_path(), array("class" => 'fancybox'))),
		$hq,
		span('cleaner', ''),
	));

	$info = array();

	if ($team->city) {
		$info[] = Stag::li(array("class" => 'icon city', "content" => $team->city));
	}

	if ($team->site) {
		$info[] = Stag::li(array("class" => 'icon site', "content" => link_for($team->site, $team->site)));
	}

	echo div('left', array(
		ul('info plain team_info', $info),
		div('team_desc desc', $team->about),
	));

	echo div('right');
		echo $renderer->heading_static(l('impro_team_events'));

		$renderer->slot('events');

	close('div');

	echo span('cleaner', '');
close('div');
