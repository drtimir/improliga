<?

echo div('team_settings_menu', ul('plain', array(
	li($ren->link_for('team_settings', $locales->trans('intra_team_settings_common'), array("args" => array($team), "strict" => true))),
	li($ren->link_for('team_settings_members', $locales->trans('intra_team_settings_members'), args($team))),

)));
