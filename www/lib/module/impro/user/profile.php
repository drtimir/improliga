<?

def($id);
def($self, false);
def($template, 'impro/user/profile');
def($link_team, '/teams/{id_impro_team}/');

if (($self && $user = user()) || ($id && $user = find('\System\User', $id))) {

	$member_of = get_all('\Impro\Team\Member')->where(array("id_system_user" => $id))->fetch();

	$this->template($template, array(
		"user"      => $user,
		"member_of" => $member_of,
		"link_team" => $link_team,
	));
}
