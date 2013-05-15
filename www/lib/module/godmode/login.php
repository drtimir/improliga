<?

def($heading, l('godmode_user_login'));

if ($request->logged_in()) {

	$flow->redirect($request->url('god_home'));

} else {

	$f = $this->form(array(
		"id" => 'core-user-login',
		"heading" => $heading,
	));

	$f->input_text('login', l("godmode_login_name"), true);
	$f->input_password('password', l("godmode_password"), true);
	$f->submit(l('Log in'));

	if ($f->passed()) {
		$p = $f->get_data();

		if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
			if ($user->login($request, $p['password'])) {
				message('success', l('godmode_login_was_successful'), NULL, true);
				$flow->redirect($request->url('god_home'));
			} else message('error', l('godmode_login'), l('godmode_bad_password'));
		} else message('error', l('godmode_login'), l('godmode_bad_login'), true);
	}

	$f->out($this);
}
