<?

def($heading, $locales->trans('intra_user_login'));
def($redirect, $ren->url('home'));

if ($request->get('redirect')) {
	$redirect = $request->get('redirect');
}

if ($request->logged_in()) {

	$flow->redirect($redirect);

} else {

	$f = $ren->form(array(
		"id" => 'login',
		"use_comm" => true,
		"heading" => $heading,
		"action" => $request->path.'?'.$request->query
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
		'placeholder' => $locales->trans("godmode_password"),
		'required' => true
	));

	$f->submit($locales->trans('intra_user_do_login'));

	if ($f->submited()) {
		$ren->flush()->reset_layout();
		$ren->format = 'json';
		$response = array("status" => 403, 'data' => array());

		if ($f->passed()) {
			$p = $f->get_data();

			if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
				if ($user->login($request, $p['password'])) {
					$response['status'] = 200;
					$response['message'] = 'logged-in';
					$response['data']['redirect'] = $redirect;
				} else {
					$response['message'] = 'user-bad-login';
				}
			} else {
				$response['message'] = 'user-does-not-exist';
			}
		} else {
			$response['message'] = 'login-failed';
		}

		$this->partial('system/common', array('json_data' => $response));
		$this->stop();
	} else {
		$f->out($this);
	}
}
