<?

$this->req('auth_uid');

$code = \System\User\Auth\Code::validate($request->get('auth_code'), $auth_uid);

if ($code) {
	$alert = get_first('\Impro\User\Alert')->where(array('id_code' => $code->id))->fetch();

	if ($alert && $alert->template == \Impro\User\Alert::TEMPLATE_INVITE_TEAM_NEW) {
		$f = $response->form(array(
			'id'       => 'register',
			'use_comm' => true,
			'heading'  => $locales->trans('intra-team-member-register'),
			'action'   => $request->path.($request->query ? '?'.$request->query:''),
			'default'  => array(
				'login' => $alert->rcpt
			)
		));

		$f->input(array(
			'type'  => 'text',
			'name'  => 'first_name',
			'label' => $locales->trans("intra-user-name-first"),
			'required' => true
		));

		$f->input(array(
			'type'  => 'text',
			'name'  => 'last_name',
			'label' => $locales->trans("intra-user-name-last"),
			'required' => true
		));

		$f->input(array(
			'type'  => 'text',
			'name'  => 'nick',
			'label' => $locales->trans("intra-user-nick")
		));

		$f->input(array(
			'type'  => 'email',
			'name'  => 'login',
			'label' => $locales->trans("intra-user-email"),
			'required' => true
		));

		$f->input(array(
			'type'  => 'password',
			'name'  => 'password',
			'label' => $locales->trans("intra-user-password"),
			'required' => true
		));

		$f->submit($locales->trans('intra-user-register'));

		if ($f->submited()) {
			// Send JSON response to the form
			$status = 400;
			$message = 'invalid-values';
			$data = null;

			if ($f->passed()) {
				$p = $f->get_data();
				$user = get_first('\System\User', array("login" => $p['login']))->fetch();

				if ($user) {
					$status  = 400;
					$message = 'user-already-exists';
				} else {
					$p['groups'] = array(3);
					$p['password'] = hash_passwd($p['password']);

					$user = create('\System\User', $p);

					$contact = create('\System\User\Contact', array(
						'user'    => $user,
						'type'    => \System\User\Contact::STD_EMAIL,
						'name'    => 'výchozí',
						'ident'   => $p['login'],
						'spam'    => true,
						'visible' => true
					));

					$member = create('\Impro\Team\Member', array(
						'active' => true,
						'team'   => $alert->team,
						'user'   => $user,
						'roles'  => array(\Impro\Team\Member\Role::ID_MEMBER)
					));

					$status = 200;
					$message = 'success';
					$data = array(
						'user' => $user->to_object()
					);

					$code->invalidate();
				}
			}

			$this->json_response($status, $message, $data);
		} else {
			$f->out($this);
		}

	} else throw new \System\Error\NotFound();
} else throw new \System\Error\AccessDenied();
