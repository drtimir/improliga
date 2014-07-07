<?

def($heading, $locales->trans('intra_user_login'));
def($redirect, $ren->url('home'));

if ($request->get('redirect')) {
	$redirect = $request->get('redirect');
}

if ($request->logged_in()) {

	$flow->redirect($redirect);

} else {

	$f = $response->form(array(
		"id" => 'login',
		"use_comm" => true,
		"heading" => $heading,
		"action" => $request->path.($request->query ? '?'.$request->query:'')
	));

	$f->input(array(
		"type" => 'text',
		'name' => 'login',
		'placeholder' => $locales->trans("user_login_name"),
		'required' => true
	));

	$f->input(array(
		'type' => 'password',
		'name' => 'password',
		'placeholder' => $locales->trans("user_login_pass"),
		'required' => true
	));

	$f->submit($locales->trans('intra_user_do_login'));

	if ($f->submited()) {
		// Form expects JSON response
		$status = 403;
		$message = 'login-failed';
		$data = null;

		if ($f->passed()) {
			$p = $f->get_data();

			if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
				if ($user->login($request, $p['password'])) {
					$status = 200;
					$message = 'logged-in';
					$data = array('redirect' => $redirect);
				} else $message = 'user-bad-login';
			} else $message = 'user-does-not-exist';
		}

		$this->json_response($status, $message, $data);
	} else {
		$f->out($this);
	}
}
