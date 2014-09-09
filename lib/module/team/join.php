<?

$data = array();
$this->req('id_team');
$aid = $request->post('alert');
$ans = $request->post('response');


if ($team = find('Impro\Team', $id_team)) {
	$alert = get_first('Impro\User\Alert')->where(array(
			'id_impro_user_alert' => $aid,
			'id_team' => $team->id,
			'id_user' => $request->user->id,
		))->fetch();

	if ($alert) {
		if ($ans) {
			$valid = true;
			$alert->response = $ans;
			$alert->read     = true;

			if ($alert->response == \Impro\User\Alert::RESPONSE_YES) {
				$member = get_first('Impro\Team\Member')->where(array(
					'id_system_user' => $request->user->id,
					'id_impro_team' => $team->id
				))->fetch();

				if ($member) {
					$data['msg']    = 'already-a-member';
					$data['status'] = 400;
					$valid = false;
				} else {
					$members = $team->members->fetch();
					$member = create('Impro\Team\Member', array(
						'team'   => $team,
						'user'   => $request->user,
						'roles'  => array(\Impro\Team\Member\Role::ID_PLAYER),
						'active' => false,
					));

					foreach ($members as $rcpt) {
						\Impro\User\Alert::generate(array(
							'author'       => $request->user,
							'type'         => Impro\User\Alert::TYPE_NOTICE,
							'template'     => Impro\User\Alert::TEMPLATE_NOTICE_JOINED,
							'generated_by' => 'auto-notice',
							'user'         => $rcpt->user,
							'team'         => $team,
							'request'      => $request,
						));
					}
				}
			}

			$alert->save();
			$data['msg']    = 'saved';
			$data['status'] = 200;
		} else {
			$data['msg']    = 'missing-answer';
			$data['status'] = 400;
		}
	} else {
		$data['msg']    = 'access-denied';
		$data['status'] = 404;
	}
} else {
	$data['msg']    = 'team-not-found';
	$data['status'] = 404;
}

$this->partial(null, $data);
