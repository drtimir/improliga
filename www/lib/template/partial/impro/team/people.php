<?

echo div('team_people');

	if ($heading) {
		echo $ren->heading($heading);
	}

	if (any($people)) {
		echo ul('plain');

			foreach ($people as $member) {
				echo li(array(
					$member->to_html_member($ren),
					span('cleaner', ''),
				));
			}

		close('ul');
	} else {
		Tag::p(array("content" => $locales->trans('intra_team_no_members')));
	}
close('div');
