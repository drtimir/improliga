<?

def($heading, l('intra_user_login'));

if ($request->logged_in()) {

	$flow->redirect($ren->url('intra_home'));

} else {

	$f = $ren->form(array("heading" => $heading));

	$f->input_text('login', l("godmode_login_name"), true);
	$f->input_password('password', l("godmode_password"), true);
	$f->submit(l('intra_user_do_login'));

	if ($f->passed()) {
		$p = $f->get_data();

		if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
			if ($user->login($request, $p['password'])) {
				$member = get_first('\Impro\Team\Member')->where(array("id_system_user" => $user->id))->fetch();
				if (any($member) || $user->is_root()) {
					$flow->redirect($ren->url('intra_home'));
				} else {
					$request->user()->logout();
					$flow->redirect($ren->url('intra_login'));
				}
			}
		}
	}

	$f->out($this);
}
