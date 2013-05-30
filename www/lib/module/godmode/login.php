<?

def($heading, $ren->trans('godmode_user_login'));

if ($request->logged_in()) {

	$flow->redirect($ren->url('god_home'));

} else {

	$f = $ren->form(array(
		"id" => 'core-user-login',
		"heading" => $heading,
	));

	$f->input_text('login', $ren->trans("godmode_login_name"), true);
	$f->input_password('password', $ren->trans("godmode_password"), true);
	$f->submit($ren->trans('Log in'));

	if ($f->passed()) {
		$p = $f->get_data();

		if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
			if ($user->login($request, $p['password'])) {
				$flow->redirect($ren->url('god_home'));
			}
		}
	}

	$f->out($this);
}
