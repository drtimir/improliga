<?

if ($propagated['team']) {

	$team = &$propagated['team'];
	$member = $team->member($request->user());

	if ($member && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DATA)) {

		$f = $ren->form(array(
			"heading" => l('intra_team_member_add'),
			"class"   => 'intra_team_member_add',
		));

		$f->input_email('email', l('contact_type_email'));
		$f->submit(l('save'));

		if ($f->passed()) {
			$p = $f->get_data();
			$contact = get_first('\System\User\Contact')->where(array(
				"type" => \System\User\Contact::STD_EMAIL,
				"ident" => $p['email']
			))->fetch();

			if (any($contact)) {
				$user = $contact->user;

				if ($user) {
					\Impro\User::load_members($user);

					if ($team->member($user)) {
						$f->report_error('email', l('intra_team_user_already_member'));
					} else {

						$rq = get_first('\Impro\User\Request')->where(array(
							"callback" => 'JoinTeam',
							"id_team"  => $team->id,
							"response" => null,
						))->fetch();

						if (empty($rq)) {
							// Not a team member and request was not sent
							$team->send_request($user, $ren, $request);
							$flow->redirect($request->path.'?result=sent');
						} else {

							// Not a team member but request was already sent. Resend email.
							$rq->mail($ren);
							$flow->redirect($request->path.'?result=resent');

						}
					}
				} else {
					// Contact found but no user, inconsistent DB keys
				}
			} else {
				// Contact not found, create new user
				$u = \Impro\User::create($ren, $request->user(), $p['email']);
				$team->send_request($u, $ren, $request);
				$flow->redirect($request->path.'?result=sent');
			}
		}

		$f->out($this);
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();