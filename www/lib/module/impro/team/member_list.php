<?

def($id_team);
def($template, 'impro/team/member_list');

if ($id_team && ($team = find('\Impro\Team', $id_team))) {
	$roles = \Impro\Team\Member\Role::get_all();
	$users = get_all('\Impro\Team\Member')->where(array("id_impro_team" => $id_team))->fetch();

	$this->template($template, array(
		"roles" => $roles,
		"users" => $users,
	));
}
