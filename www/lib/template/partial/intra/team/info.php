<?

$ren->content_for('title', ' - Informace');


echo div('team_info');

	echo $ren->heading(l('impro_team_info'));
	echo div('desc', \System\Template::to_html($team->about));

	$props = array();

	if ($team->city) {
		$props[] = li($team->city, 'icon city');
	}

	if ($team->mail) {
		$props[] = li($ren->link('mailto:'.$team->mail, $team->mail), 'icon mail');
	}

	if ($team->site) {
		$props[] = li($ren->link($team->site, $team->site), 'icon site');
	}

	if (any($props)) {
		echo ul('props', $props);
	}

close('div');
