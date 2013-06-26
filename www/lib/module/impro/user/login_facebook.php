<?

def($redirect, $ren->url('home'));

if ($request->get('redirect')) {
	$redirect = $request->get('redirect');
}

if ($request->facebook && ($account = $request->facebook->get_account())) {
	if ($account->id_user) {
		$flow->redirect($redirect);
	} else {

		$f = $ren->form(array(
			"heading" => $locales->trans('user_facebook_confirm'),
			"desc"    => $locales->trans('user_facebook_confirm_desc'),
		));

		$f->input_text('login', $locales->trans("godmode_login_name"), true);
		$f->input_password('password', $locales->trans("godmode_password"), true);
		$f->submit($locales->trans('intra_user_do_login'));
		$f->out($this);

		if ($f->passed()) {
			$p = $f->get_data();

			if ($user = get_first('\System\User', array("login" => $p['login']))->fetch()) {
				if ($user->login($request, $p['password'])) {
					$account->user = $user;
					$account->save();
					$flow->redirect($redirect);
				}
			}
		}
	}
}
