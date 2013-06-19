<?

echo div('team_settings_menu', ul('plain', array(
	li($ren->link_for('profile_settings', $ren->trans('user_settings_basic'), array("strict" => true))),
	li($ren->link_for('profile_settings_contacts', $ren->trans('user_settings_contacts'))),
	li($ren->link_for('profile_settings_passwd', $ren->trans('user_settings_passwd'))),
)));
