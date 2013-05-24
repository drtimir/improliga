<?

def($heading, l('intra_user_login'));
def($redirect, $ren->url('home'));

if ($request->get('redirect')) {
	$redirect = $request->get('redirect');
}

if ($request->logged_in()) {

	$flow->redirect($redirect);

} else {

	$f = $ren->form(array("heading" => $heading, "action" => $request->path.'?'.$request->query));

	$f->input_text('login', l("godmode_login_name"), true);
	$f->input_password('password', l("godmode_password"), true);
	$f->submit(l('intra_user_do_login'));

	if ($f->passed()) {
		$p = $f->get_data();

		if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
			if ($user->login($request, $p['password'])) {
				$flow->redirect($redirect);
			}
		}
	}

	$f->out($this);
}
