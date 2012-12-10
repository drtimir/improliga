<?

echo heading($user->get_name());

$props = Tag::div(array(
	"class"   => 'info',
	"output"  => false,
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

$gl = $user->groups->fetch();
$group_list = array();

foreach ($gl as $g) {
	$group_list[] = Tag::li(array(
		"output"  => false,
		"content" => $g->name,
	));
}

$groups = Tag::ul(array(
	"content" => $group_list,
	"output"  => false,
));


Tag::div(array(
	"class"   => "detail-user",
	"content" => array(
		$props,
		heading(l('godmode_user_groups')),
		$groups,
	)
));
