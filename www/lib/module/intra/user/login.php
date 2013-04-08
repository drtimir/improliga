<?

def($redirect_to, '/');
def($heading, l('intra_user_login'));

if (System\User::logged_in()) {

	System\Flow::redirect($redirect_to);

} else {
	$f = new System\Form(array(
		"heading" => $heading,
	));

	$f->input_text('login', l("godmode_login_name"), true);
	$f->input_password('password', l("godmode_password"), true);
	$f->submit(l('intra_user_do_login'));

	if ($f->passed()) {
		$p = $f->get_data();

		if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
			if (System\User::login($user, $p['password'])) {
				$member = get_first('\Impro\Team\Member')->where(array("id_system_user" => user()->id))->fetch();
				if (any($member) || $user->is_root()) {
					message('success', l('godmode_login_was_successful'), NULL, true);
					System\Flow::redirect($redirect_to);
				} else {
					message('success', l('intra_user_not_member'), NULL, true);
					System\User::logout();
					System\Flow::redirect('/');
				}
			} else message('error', l('godmode_login'), l('godmode_bad_password'));
		} else message('error', l('godmode_login'), l('godmode_bad_login'), true);
	}

	$f->out($this);
}
