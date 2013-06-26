<?

echo div('support');

	echo $ren->heading($locales->trans('intra_support'));

	echo p($locales->trans('intra_support_desc'));

	foreach ($groups as $group) {
		echo $ren->heading_static($group->name);
		$users = $group->users->fetch();

		echo ul('plain');
			foreach ($users as $user) {
				$contacts = $user->contacts->where(array("public" => true))->fetch();
				$con = '';

				if (any($contacts)) {
					$cc = array();

					foreach ($contacts as $contact) {
						$cc[] = li(\Impro\User::contact_to_html($ren, $contact));
					}
					$con = ul('contacts', $cc);
				}

				echo li(array(
					div('l', span('avatar', \Impro\User::avatar($ren, $user))),
					div('r', array(
						div('name', \Impro\User::link($ren, $user)),
						$con,
					))
				));
			}
		close('ul');
	}

close('div');
