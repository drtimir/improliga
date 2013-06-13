<?

echo div('profile');
	echo div('left');
		echo $ren->heading($user->get_name());
		echo $ren->heading($user->nick);

		echo div('member_teams profile_block');
			echo $ren->heading_static($locales->trans('intra_user_teams'));

			if (any($member_of)) {
				echo ul('plain teams');

					foreach ($member_of as $member) {
						echo li($member->to_html($ren));
					}

				Tag::close('ul');
			} else {
				Tag::p(array("class" => 'info', "content" => $locales->trans('intra_user_has_no_teams')));
			}
		close('div');

		if (any($contacts)) {

			echo div('member_contact profile_block');
				echo $ren->heading_static($locales->trans('intra_user_contacts'));

					echo ul('plain contacts');
						foreach ($contacts as $contact) {
							echo li(\Impro\User::contact_to_html($ren, $contact));
						}
					close('ul');
			close('div');
		}

	close('div');

	echo div('right');
		echo div('profile_block member_avatar fancybox', $ren->link($user->avatar->get_path(), $user->avatar->to_html($ren, 360,275)));

		if (any($events)) {
			echo div('profile_block member_events');
				echo $ren->heading_static($locales->trans('intra_user_events'));

				echo ul('plain events');
					foreach ($events as $event) {
						echo li($event->to_html($ren));
					}
				close('ul');
			close('div');
		}

	close('div');
close('div');
