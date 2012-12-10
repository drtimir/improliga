<?

def($team_id);
def($group_id, 4);


if ($team_id && $team = find("\Impro\Team", $team_id)) {

	$group = find('\System\User\Group', $group_id);
	$users = $group->users->fetch();

	$f = new System\Form(array());
	$f->input(array(
		"type"    => 'select',
		"name"    => "id_system_user",
		"options" => $users,
		"label"   => l('godmode_user'),
	));

	$f->out($this);

}
