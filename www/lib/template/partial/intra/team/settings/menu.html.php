<?

echo div('team_settings_menu', ul('plain', array(
	li($ren->link_for('team_settings', l('intra_team_settings_common'), args($team))),
	li($ren->link_for('team_settings_members', l('intra_team_settings_members'), args($team))),

)));
