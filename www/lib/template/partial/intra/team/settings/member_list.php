<?

echo div('team_member_list');
	echo $ren->heading(l('intra_team_member_list'));
	echo ul('plain');

	foreach ($members as $member) {
		echo li(array(
			$member->to_html_member($ren),
			ul('controls', array(
				li($ren->icon_for_url('team_settings_member_roles', 'godmode/actions/edit', 16, array(
					"args"  => array($team, $member->id),
					"title" => l('intra_team_member_edit'),
				))),
				li($ren->icon_for_url('team_settings_member_drop', 'godmode/actions/delete', 16, array(
					"args"  => array($team, $member->id),
					"class" => 'ask',
					"title" => l('intra_team_member_drop'),
				))),
			)),

		));
	}

	close('ul');
close('div');
