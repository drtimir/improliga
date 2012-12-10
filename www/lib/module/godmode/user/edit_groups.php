<?

def($id);
def($redirect, '/god/users/{id_system_user}/');

if ($id && $user = find("\System\User", $id)) {

	$groups_user = $user->groups->fetch();
	$groups_available = get_all('\System\User\Group')->fetch();
	$heading = l('godmode_user_edit_groups_assignment');

	$options = array();

	foreach ($groups_available as $group) {
		$options[$group->id] = $group->name;
	}

	$f = new System\Form(array("id" => 'edit_user_groups', "heading" => $heading));

	$f->input(array(
		"type"     => 'checkbox',
		"name"     => 'groups',
		"multiple" => true,
		"options"  => $options,
		"value"    => $user->get_group_ids(),
		"label"    => l('godmode_user_groups'),
	));

	$f->submit(l('godmode_save'));

	if ($f->passed()) {

		$p = $f->get_data();
		$user->assign_rel('groups', $p['groups']);

		if (!$user->errors()) {
			message('success', $heading, l('godmode_save_success'), true);
			redirect(soprintf($redirect, $user));
		}

	} else {
		$f->out($this);
	}

} else $this->error('params');
