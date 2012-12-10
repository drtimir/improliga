<?

def($id);
def($link_cont, '/god/users/');
def($heading, l('godmode_user_delete'));

if($id && $user = find("\System\User", $id)){

	$ed = System\Form::create_delete_checker(array(
		"submit" => l('godmode_delete'),
		"heading" => $heading,
		"info" => array(
			l('godmode_user_name')  => $user->get_name(),
			l('godmode_user_login') => $user->login,
			l('godmode_nick') => $user->nick,
		),
	));

	if ($ed->passed()) {

		$user->drop() ?
			message('success', $heading, l('godmode_delete_success')):
			message('error', $heading, l('godmode_delete_fail'));

		redirect(soprintf($link_cont, $user));

	} else $ed->out($this);
} else $this->error('params');
