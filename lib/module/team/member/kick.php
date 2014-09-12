<?

$data = array();

$this->req('id_team');
$this->req('id_member');

$team   = find('Impro\Team', $id_team);
$member = find('Impro\Team\Member', $id_member);

if ($team && $member && $team->id == $member->team->id) {
	$org_member = $team->members->where(array('id_system_user' => $request->user->id))->fetch_one();

	if ($org_member && $org_member->has_right(Impro\Team\Member\Role::PERM_TEAM_ORGANIZE)) {
		$alert = array(
			'request'      => $request,
			'type'         => Impro\User\Alert::TYPE_NOTICE,
			'generated_by' => 'organic-kick',
			'author'       => $request->user,
			'team'         => $team,
			'allow_maybe'  => false
		);

		if ($member->user->id == $request->user->id) {
			// User has been kicked. Report to him.
			Impro\User\Alert::generate(array_merge($alert, array(
				'template' => Impro\User\Alert::TEMPLATE_NOTICE_KICKED,
				'user'     => $member->user,
			));
		} else {
			// User has voluntarily left the team. Report to all members
			$all = $team->members->fetch();

			foreach ($all as $rcpt) {
				Impro\User\Alert::generate(array_merge($alert, array(
					'template' => Impro\User\Alert::TEMPLATE_NOTICE_LEFT,
					'user'     => $rcpt->user,
				));
			}
		}

		//~ $member->drop();

		$data['msg']    = 'kicked';
		$data['status'] = 200;
	} else {
		$data['msg']    = 'access-denied';
		$data['status'] = 403;
	}
} else {
	$data['msg']    = 'not-found';
	$data['status'] = 404;
}

$this->partial(null, $data);
