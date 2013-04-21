<?

echo div('team_info');

	echo section_heading(l('impro_team_info'));
	echo div('desc', \System\Template::to_html($team->about));

	$props = array();

	if ($team->city) {
		$props[] = Stag::li(array("class" => 'icon city', "content" => $team->city));
	}

	if ($team->mail) {
		$props[] = Stag::li(array("class" => 'icon mail', "content" => $team->mail));
	}

	if ($team->site) {
		$props[] = Stag::li(array("class" => 'icon site', "content" => link_for($team->site, $team->site)));
	}

	if (any($props)) {
		echo ul('props', $props);
	}

close('div');
