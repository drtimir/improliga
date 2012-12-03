<?

def($id);
def($link_cont, '/god/users/groups/');
def($heading, l('godmode_user_group_delete'));

if($id && $group = find("\System\User\Group", $id)){

	$ed = System\Form::create_delete_checker(array(
		"submit" => l('godmode_delete'),
		"heading" => $heading,
		"info" => array(
			l('godmode_name') => $group->name,
			l('godmode_user_count') => $group->users->count(),
		),
	));

	if ($ed->passed()) {

		$group->drop() ?
			message('success', $heading, l('godmode_delete_success')):
			message('error', $heading, l('godmode_delete_fail'));

		redirect(soprintf($link_cont, $group));

	} else $ed->out($this);
} else $this->error('params');
