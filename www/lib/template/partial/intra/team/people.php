<?


echo div('team_people');

	if ($heading) {
		echo $ren->heading($heading);
	}

	echo ul('plain');

		foreach ($people as $member) {
			li(array(
				$member->to_html_member($ren, $link_user),
				span('cleaner', ''),
			));
		}

	close('ul');
close('div');
