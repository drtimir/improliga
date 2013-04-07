<?


echo div('team_people');

	echo ul('plain');

		foreach ($people as $member) {
			Tag::li(array(
				"content" => $member->to_html_member($link_user),
			));
		}

	close('ul');

close('div');
