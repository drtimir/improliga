<?


echo div('team_people');

	if ($heading) {
		echo section_heading($heading);
	}

	echo ul('plain');

		foreach ($people as $member) {
			Tag::li(array(
				"content" => array(
					$member->to_html_member($link_user),
					span('cleaner', ''),
				)
			));
		}

	close('ul');

close('div');
