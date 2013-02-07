<?

Tag::div(array("class" => 'profile'));
	echo section_heading($user->get_name());
	echo section_heading($user->nick, 2);

	echo section_heading(l('impro_user_teams'), 3);

	if (any($member_of)) {
		Tag::ul(array("class" => 'teams plain'));

		foreach ($member_of as $member) {
			Tag::li();
				Tag::div(array(
					"class" => 'name',
					"content" => array(
						link_for($member->team->name, soprintf($link_team, $member)),
						' - ',
						link_for($member->team->name_full, soprintf($link_team, $member)),
				)));


				$roles = array();
				foreach ($member->roles as $role) {
					$roles[] = Impro\Team\Member\Role::get_name($role);
				}

				Tag::div(array(
					"class"   => 'roles',
					"content" => implode(', ', $roles),
				));
			Tag::close('li');
		}

		Tag::close('ul');
	} else {
		Tag::p(array("class" => 'info', "content" => l('impro_user_has_no_teams')));
	}

Tag::close('div');
