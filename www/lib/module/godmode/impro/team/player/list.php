<?

def($team_id);
def($link_cont, '/god/impro/teams/{id_impro_team}/players/');
def($heading, l('godmode_impro_team_player_list'));
def($per_page, 20);
def($page, 0);
def($conds, array());
def($opts, array());

if ($team_id && $team = find("\Impro\Team", $team_id)) {

	$users = $team->players->where($conds)->paginate($per_page, $page)->fetch();
	$count = $team->players->where($conds)->count();

	$this->template('godmode/item-list', array(
		"cols" => array(
			array('login', l('godmode_user_login'), 'link', $link_cont),
			array('get_name', l('godmode_user_name'), 'link-function', $link_cont),
			array('updated_at', l('godmode_last_login'), 'date'),
			array('created_at', l('godmode_created_at'), 'date'),
			array(null, null, 'actions', array(l('godmode_edit') => 'edit', l('godmode_delete') => 'delete')),
		),
		"items"     => $users,
		"link_cont" => $link_cont,
		"heading"   => def($show_heading, true) ? def($heading, l('User list')):null,
	));

}
