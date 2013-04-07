<?

echo div('team_info');

	echo div('desc', \System\Template::to_html($team->about));

	$props = array();

	if ($team->city) {
		$props[] = Stag::li(array("class" => 'icon city', "content" => $team->city));
	}

	if ($team->site) {
		$props[] = Stag::li(array("class" => 'icon site', "content" => link_for($team->site, $team->site)));
	}

	if (any($props)) {
		echo ul('props', $props);
	}

close('div');
