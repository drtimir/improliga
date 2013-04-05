<?

echo div('profile');
	echo div('left');
		echo section_heading($user->get_name());
		echo section_heading($user->nick, 2);

		echo div('member_teams profile_block');
			echo heading(l('intra_user_teams'), false);

			if (any($member_of)) {
				echo ul('plain teams');

					foreach ($member_of as $member) {
						Tag::li(array("content" => $member->to_html($link_team)));
					}

				Tag::close('ul');
			} else {
				Tag::p(array("class" => 'info', "content" => l('intra_user_has_no_teams')));
			}
		close('div');

		if (any($contacts)) {

			echo div('member_contact profile_block');
				echo heading(l('intra_user_contacts'), false);

					echo ul('plain contacts');
						foreach ($contacts as $contact) {
							Tag::li(array("content" => \Impro\User::contact_to_html($contact)));
						}
					close('ul');
			close('div');
		}

	close('div');

	echo div('right');

		echo div('profile_block member_avatar', link_for(\Stag::img(array('src' => $user->avatar->thumb_trans(360,275))), $user->avatar->get_path()));

		if (any($events)) {
			echo div('profile_block member_events');
				echo heading(l('intra_user_events'), false);

				echo ul('plain events');
					foreach ($events as $event) {
						Tag::li(array("content" => $event->to_html($link_event)));
					}
				close('ul');
			close('div');

		}

	close('div');
close('div');
