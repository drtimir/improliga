<?

$this->req('id_team');

$data = array();
$name = $request->post('name');

if ($team = find('Impro\Team', $id_team)) {
	$member = $team->members->where(array('id_system_user' => $request->user->id))->fetch_one();

	if ($member && $member->has_right(Impro\Team\Member\Role::PERM_TEAM_ORGANIZE)) {
		$user    = null;
		$tmember = null;

		// First, try locating user using contacts
		$contact = get_first('System\User\Contact')
			->where(array('ident' => $name))
			->fetch();

		if (any($contact)) {
			$user = $contact->user;
		}

		if (!$user) {
			// User was not found using contacts, try looking for login
			$user = get_first('\System\User')->where(array('login' => $name))->fetch_one();
		}

		if ($user) {
			// Lookup this user among team members
			$tmember = $team->members->where(array('id_system_user' => $user->id))->fetch_one();

			if ($tmember) {
				// User exists and is a member of the team
				$data['msg']    = 'already-member';
				$data['status'] = 400;
			} else {
				/* User already exists but he is not a member of this team. Send him
				 * regular invite
				 */
				Impro\User\Alert::generate(array(
					'type'         => Impro\User\Alert::TYPE_REQUEST,
					'template'     => Impro\User\Alert::TEMPLATE_INVITE_TEAM,
					'generated_by' => 'organic-invite',
					'author'       => $request->user,
					'user'         => $user,
					'team'         => $team,
					'allow_maybe'  => false
				));

				$data['msg'] = 'success';
				$data['status'] = 200;
			}
		} else {
			// User does not exist, send him invite to intranet
			$user = create('\System\User', array(
				'login'    => $name,
				'groups'   => array(3)
			));

			$contact = create('\System\User\Contact', array(
				'user'  => $user,
				'ident' => $name,
				'name'  => 'výchozí',
				'spam'  => true,
				'type'  => \System\User\Contact::STD_EMAIL
			));
		}


		if ($user && !$tmember) {
		}
	} else {
		$data['msg']    = 'access-denied';
		$data['status'] = 403;
	}
} else {
	$data['msg']    = 'team-not-found';
	$data['status'] = 404;
}


$this->partial(null, $data);
