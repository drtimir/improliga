<?

echo $renderer->heading(l('godmode_user_perms_for_module'));

Tag::table();
	Tag::thead();
		Tag::tr();
			Tag::th(array("content" => l('godmode_user_group')));
			Tag::th(array());
			Tag::th(array());
		Tag::close('tr');
	Tag::close('thead');
	Tag::tbody();
		foreach ($groups as $group) {
			Tag::tr();
				Tag::td(array("content" => $group->name));
				Tag::td(array("content" => in_array($group->id, $groups_perm) ? 'allowed':'global'));

				Tag::td(array(
					"content" => Tag::a(array(
						"href"    => stprintf($link_switch, array("path" => $path, "group_id" => $group->id)),
						"content" => 'switch',
						"output"  => false,
					))
				));

			Tag::close('tr');
		}
	Tag::close('tbody');

Tag::close('table');
