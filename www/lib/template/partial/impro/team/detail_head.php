<?

$ren->content_for('title', $team->name);

$manage_menu = '';

if ($member) {
	$manage_menu_opts = array();

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DISCUSSION)) {
		$manage_menu_opts[] = li($ren->link_for('team_discussion', $locales->trans('intra_team_discussion'), array("args" => array($team), "class" => 'button')));
	}

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DATA)) {
		$manage_menu_opts[] = li($ren->link_for('team_settings', $locales->trans('intra_team_settings'), array("args" => array($team), "class" => 'button')));
	}

	if ($team->use_attendance && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ATTENDANCE)) {
		$manage_menu_opts[] = li($ren->link_for('team_attendance', $locales->trans('intra_team_attendance'), array("args" => array($team), "class" => 'button')));
	}

	$manage_menu = ul('plain options manage', $manage_menu_opts);
}


echo div('team_detail');

	echo div('header', array(
		div('gallery fancybox', array(
			div('team_logo', $ren->link($team->logo->get_path(), $team->logo->to_html($ren, 205, 180))),
			div('img', $ren->link($team->photo->get_path(), $team->photo->to_html($ren, 370, 180))),
			$team->hq ?
				div('map', array(
					$team->hq->map_html($ren, 205, 180),
					div('playground label', $ren->link_ext(
						$team->hq->map_link(),
						div('inner', array(
							$ren->heading('Domácí hřiště', 3, false),
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
			div('name', $ren->heading_layout($team->to_html_link($ren, false))),
			ul('plain options', array(
				li($ren->link_for('team', $locales->trans('intra_team_home'), array("args" => array($team), "class" => 'button', "strict" => true))),
				li($ren->link_for('team_info', $locales->trans('intra_team_info'), array("args" => array($team), "class" => 'button'))),
				li($ren->link_for('team_events', $locales->trans('intra_team_events'), array("args" => array($team), "class" => 'button'))),
			)),
			$manage_menu,
		)),
		div('cleaner', ''),
	));

	span('cleaner', '');
close('div');
