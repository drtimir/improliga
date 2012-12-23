<?

echo heading(l('impro_team_member_detail', $team->get_name()));


Tag::div(array("class" => "info"));

	Tag::div(array(
		"class"   => 'info',
		"content" => array(
			Tag::ul(array(
				"output"  => false,
				"class"   => 'proplist',
				"content" => array(
					Tag::li(array(
						"output"  => false,
						"content" => array(
							Tag::span(array(
								"output"  => false,
								"class"   => 'l',
								"content" => l('godmode_user_name').':',
							)),
							Tag::span(array(
								"output"  => false,
								"class"   => 'r',
								"content" => $user->get_name(),
							))
						)
					)),
					Tag::li(array(
						"output"  => false,
						"content" => array(
							Tag::span(array(
								"output"  => false,
								"class"   => 'l',
								"content" => l('godmode_user_login').':',
							)),
							Tag::span(array(
								"output"  => false,
								"class"   => 'r',
								"content" => $user->login,
							))
						)
					)),
					Tag::li(array(
						"output"  => false,
						"content" => array(
							Tag::span(array(
								"output"  => false,
								"class"   => 'l',
								"content" => l('godmode_nick').':',
							)),
							Tag::span(array(
								"output"  => false,
								"class"   => 'r',
								"content" => $user->nick,
							))
						)
					))
				)
			)),
		),
	));

	Tag::ul();
		Tag::li(array(
			"content" => Tag::a(array(
				"output"  => false,
				"href"    => '/god/users/'.$user->id.'/edit/',
				"content" => l('impro_team_member_account_edit'),
				"class"   => 'newwin',
			))
		));
	Tag::close('ul');

	if (any($other)) {
		v($other);
	}

Tag::close('div');
