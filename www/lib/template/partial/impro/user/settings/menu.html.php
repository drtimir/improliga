<?

echo div('team_settings_menu', ul('plain', array(
	li($ren->link_for('profile_settings', 'Základní nastavení', array("strict" => true))),
	li($ren->link_for('profile_settings_contacts', 'Kontakty')),
)));
