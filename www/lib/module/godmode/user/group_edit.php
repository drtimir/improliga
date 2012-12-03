<?

def($id);
def($new, false);
def($link_cont, '/god/users/groups/');
def($heading, $new ? l('godmode_user_group_create'):l('godmode_user_group_edit'));

if (($new && $group = new System\User\Group()) || ($id && $group = find("\System\User\Group", $id))) {

	$f = new System\Form(array(
		"id" => 'core-user-group-edit',
		"heading" => $heading,
		"default" => $group->get_data(),
	));

	$f->input_text('name', l('godmode_name'), true);
	$f->submit($new ? l('godmode_create'):l('godmode_edit'));

	if ($f->passed()) {

		$d = $f->get_data();
		$group->update_attrs($d)->save();

		if (!$group->errors()) {
			message('success', $heading, l('godmode_save_success'));
			redirect(soprintf($link_cont, $group));
		} else {
			message('error', $heading, l('godmode_save_fail'));
		}
	}

	if (!$f->passed() || $group->errors()) {
		$f->out($this);
	}

} else $this->error('params');
