<?

if ($propagated['team']) {

	$team = &$propagated['team'];

	$f = $ren->form(array(
		"heading" => l('intra_team_member_add')
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
					$rq = \Impro\User\Request::for_user($user, array(
						"text"         => stprintf(l('intra_team_member_add_text'), array(
							"link_team" => $team->to_html_link($ren),
							"link_user" => \Impro\User::link($ren, $request->user()),
						)),
						"id_author"    => $request->user()->id,
						"id_team"      => $team->id,
						"callback"     => 'JoinTeam',
						"redirect_yes" => $ren->url('team', array($team)),
						"allow_maybe"  => false,
					))->mail($ren);

					$flow->redirect($request->path);

					// Not a team member, send request
				}
			} else {
				// Contact found but no user, inconsistent DB keys
			}
		} else {
			// Contact not found, create new user
		}
	}

	$f->out($this);

} else throw new \System\Error\NotFound();
