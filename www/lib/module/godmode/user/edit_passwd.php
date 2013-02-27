<?

$this->req('id');
$this->req('link_cont');

if ($id && $user = find("\System\User", $id)) {

	$heading = l('godmode_user_edit_passwd');
	$f = new System\Form(array("id" => 'edit_user_groups', "heading" => $heading));

	$f->input_password('password', l('godmode_user_password'), true);
	$f->input_password('password_check', l('godmode_user_password_check'), true);
	$f->submit(l('godmode_save'));

	if ($f->passed()) {

		$p = $f->get_data();
		if ($p['password'] === $p['password_check']) {
			$p['password'] = hash_passwd($p['password']);
			$user->update_attrs($p)->save();
			redirect(soprintf($link_cont, $user));
		} else {
			$f->out($this);
		}
	} else {
		$f->out($this);
	}

} else {
v($id);
	//~ throw new System\Error\NotFound();
}
