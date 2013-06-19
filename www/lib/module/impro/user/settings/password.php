<?

$user = $request->user();

$f = $ren->form(array(
	"heading" => $ren->trans('user_settings_passwd_heading'),
));

$f->input_password('old',   $ren->trans('user_passwd_old'), true);
$f->input_password('new',   $ren->trans('user_passwd_new'), true);
$f->input_password('recap', $ren->trans('user_passwd_recap'), true);
$f->submit($ren->trans('user_settings_passwd'));

$f->out();

if ($f->passed()) {
	$p = $f->get_data();

	if ($p['new'] == $p['recap']) {
		$hash = hash_passwd($p['old']);
		if ($user->password == $hash) {
			$user->password = hash_passwd($p['new']);
			$user->save();
			$flow->redirect($ren->url('profile_settings_passwd').'?saved=true');
		}
	}
}


