<?

echo div('team_people');

	if ($heading) {
		echo $ren->heading($heading);
	}

	if (any($people)) {
		echo ul('plain');

			foreach ($people as $member) {
				echo li(array(
					$member->to_html_member($ren, $link_user),
					span('cleaner', ''),
				));
			}

		close('ul');
	} else {
		echo Tag::p(array("content" => l('intra_team_no_members')));
	}
close('div');
