<?

$this->req('id');
$this->req('link_god');

if ($id && $user = find("\System\User", $id)) {

	$heading = $locales->trans('godmode_user_edit_passwd');
	$f = $ren->form(array("id" => 'edit_user_groups', "heading" => $heading));

	$f->input_password('password', $locales->trans('godmode_user_password'), true);
	$f->input_password('password_check', $locales->trans('godmode_user_password_check'), true);
	$f->submit($locales->trans('godmode_save'));

	if ($f->passed()) {

		$p = $f->get_data();
		if ($p['password'] === $p['password_check']) {
			$p['password'] = hash_passwd($p['password']);
			$user->update_attrs($p)->save();
			$flow->redirect(\Godmode\Router::url($request, $link_god, 'detail', array($user->id)));
		} else {
			$f->out($this);
		}
	} else {
		$f->out($this);
	}

} else throw new System\Error\NotFound();
