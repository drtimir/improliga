<?

def($redirect_to, def($_SESSION['yacms-referer'], '/god/'));
def($heading, l('User login'));

if (System\User::logged_in()) {

	redirect($redirect_to);

} else {

	$f = new System\Form(array(
		"id" => 'core-user-login',
		"heading" => $heading,
	));

	$f->input_text('login', l("godmode_login_name"), true);
	$f->input_password('password', l("godmode_password"), true);
	$f->submit(l('Log in'));

	if ($f->passed()) {
		$p = $f->get_data();

		if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
			if (System\User::login($user, $p['password'])) {
				message('success', l('godmode_login_was_successful'), NULL, true);
				redirect($redirect_to);
			} else message('error', l('godmode_login'), l('godmode_bad_password'));
		} else message('error', l('godmode_login'), l('godmode_bad_login'), true);
	}

	$f->out($this);
}
