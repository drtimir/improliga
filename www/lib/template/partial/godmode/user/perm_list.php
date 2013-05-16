<?

echo $renderer->heading(l('godmode_user_perms_list'));

Tag::ul(array("class" => 'perm-list'));

foreach ($mods as $mod) {

	$mod['path'] = str_replace('/', '::', $mod['path']);

	Tag::li(array(
		"content" => array(
			Tag::a(array(
				"output"  => false,
				"href"    => stprintf($link_cont, $mod),
				"content" => $mod['path'],
			)),
		)
	));
}

Tag::close('ul');
