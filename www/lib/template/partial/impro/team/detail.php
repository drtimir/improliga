<?

$ren->content_for('title', $locales->trans('title_impro_team', $team->name));

echo div('team_detail');

	$hq = $team->hq ? div('map', array(
		$team->hq->map_html($ren, 300, 300),
		div('playground', array(
			$ren->heading_static('Domácí hřiště', 3),
			div('location', array(
				Stag::strong(array("content" => $team->hq->name)),
				Stag::br(),
				span('addr', $team->hq->addr),
			)),
		)),
	)):'';

	echo div('header', array(
		div('team_heading', array(
			div('team_logo', $ren->link($team->logo->get_path(), $team->logo->to_html($ren, 188, 165), array("class" => 'fancybox'))),
			div('name', array(
				$ren->heading($team->name, 1),
				$ren->heading($team->name_full),
			))
		)),
		div('img', $ren->link($team->photo->get_path(), $team->photo->to_html($ren, 600, 300), array("class" => 'fancybox'))),
		$hq,
		span('cleaner', ''),
	));

	$info = array();

	if ($team->city) {
		$info[] = li($team->city, 'icon city');
	}

	if ($team->accepting) {
		$info[] = li($ren->trans('attr_impro_team_accepting'), 'icon accepting');
	}

	if ($team->site) {
		$info[] = li($ren->link($team->site, $team->site), 'icon site');
	}


	echo div('left', array(
		ul('info plain team_info', $info),
		div('team_desc desc', to_html($ren, $team->about)),
	));

	echo div('right');
		echo $ren->heading_static($locales->trans('impro_team_events'));

		$ren->slot('events');

	close('div');

	echo span('cleaner', '');
close('div');
