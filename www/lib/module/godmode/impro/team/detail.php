<?

def($id, null);
def($link_cont, '/god/impro/teams/{id_impro_team}/members/{id_system_user}/');

if ($id && ($team = find('\Impro\Team', $id))) {

	$this->template('godmode/impro/team/detail', array("team" => $team,));
	$this->template('godmode/item-list', array(
		"cols" => array(
			array('get_name', l('godmode_user_name'), 'link-function', '/'),
			array('roles', l('impro_team_member_roles'), 'list', Impro\Team\Member\Role::get_all()),
			array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
		),
		"items"     => $team->members->fetch(),
		"link_cont" => $link_cont,
		"heading"   => def($show_heading, true) ? def($heading, l('User list')):null,
	));

}
