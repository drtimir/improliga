<?

echo heading($team->get_name());

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
							"content" => l('impro_team_matches_played').':',
						)),
						Tag::span(array(
							"output"  => false,
							"class"   => 'r',
							"content" => $team->played,
						))
					)
				)),
				Tag::li(array(
					"output"  => false,
					"content" => array(
						Tag::span(array(
							"output"  => false,
							"class"   => 'l',
							"content" => l('impro_team_site').':',
						)),
						Tag::a(array(
							"output"  => false,
							"class"   => 'r',
							"href"    => $team->site,
							"content" => $team->site,
						))
					)
				)),
				Tag::li(array(
					"output"  => false,
					"content" => array(
						Tag::span(array(
							"output"  => false,
							"class"   => 'l',
							"content" => l('godmode_visibility').':',
						)),
						Tag::span(array(
							"output"  => false,
							"class"   => 'r',
							"content" => l($team->visible ? 'yes':'no'),
						))
					)
				))
			)
		)),
	),
));

$about = Tag::div(array(
	"class"   => 'about',
	"output"  => false,
	"content" => $team->about
));


Tag::div(array(
	"class"   => "detail-team",
	"content" => array(
		$props,
		$about,
	)
));
