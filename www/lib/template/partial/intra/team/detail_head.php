<?

$manage_menu = '';

if ($member) {
	$manage_menu = ul('plain options manage', array(
		$member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DISCUSSION) ? Stag::li(array(
			"content" => $ren->link_for('intra_team_discussion', l('intra_team_discussion'), array("args" => array($team), "class" => 'button'))
		)):'',
		$member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DATA) ? Stag::li(array(
			"content" => $ren->link_for('intra_team_settings', l('intra_team_settings'), array("args" => array($team), "class" => 'button'))
		)):'',
	));
}


echo div('team_detail');

	echo div('header', array(
		div('gallery fancybox', array(
			div('team_logo', $ren->link($team->logo->get_path(), $team->logo->to_html(210, 180))),
			div('img', $ren->link($team->photo->get_path(), $team->photo->to_html(370, 180))),
			$team->hq ?
				div('map', array(
					$team->hq->map_html(210, 180),
					div('playground label', $ren->link(
						$team->hq->map_link(),
						div('inner', array(
							$ren->heading('Domácí hřiště', false, 3),
							div('location', array(
								Stag::strong(array("content" => $team->hq->name)),
								Stag::br(),
								span('addr', $team->hq->addr),
							)),
						))
					)),
				)):'',
			span('cleaner', ''),
		)),
		div('menu', array(
			div('name', $ren->heading($team->to_html_link($ren, false))),
			ul('plain options', array(
				li($ren->link_for('intra_team', l('intra_team_home'), array("args" => array($team), "class" => 'button', "strict" => true))),
				li($ren->link_for('intra_team_info', l('intra_team_info'), array("args" => array($team), "class" => 'button'))),
				li($ren->link_for('intra_team_events', l('intra_team_events'), array("args" => array($team), "class" => 'button'))),
			)),
			$manage_menu,
		)),
		div('cleaner', ''),
	));

	span('cleaner', '');
close('div');
