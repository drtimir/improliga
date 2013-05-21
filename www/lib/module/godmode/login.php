<?

def($heading, l('godmode_user_login'));

if ($request->logged_in()) {

	$flow->redirect($request->url('god_home'));

} else {

	$f = $ren->form(array(
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
				$flow->redirect($request->url('god_home'));
			}
		}
	}

	$f->out($this);
}
