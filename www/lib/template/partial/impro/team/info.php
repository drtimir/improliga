<?

$ren->content_for('title', ' - Informace');


echo div('team_info');

	echo $ren->heading($locales->trans('impro_team_info'));
	echo div('desc', to_html($ren, $team->about));

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
