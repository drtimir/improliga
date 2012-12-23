<?

def($team_id);
def($group_id, 4);
def($redirect, '/god/impro/teams/{id_impro_team}');

if ($team_id && $team = find("\Impro\Team", $team_id)) {
	$roles = Impro\Team\Member\Role::get_all();

	$f = new System\Form(array(
		"heading" => l('godmode_add_player_to_team'),
	));

	$f->input(array(
		"type"     => 'search_tool',
		"name"     => "users",
		"model"    => 'System\User',
		"display"  => array('get_name'),
		"label"    => l('godmode_user_name'),
		"info"     => l('search_user_by_name'),
		"has"      => array('groups' => array($group_id)),
		"filter"   => array('login', 'nick', 'first_name', 'last_name'),
		"placeholder" => 'Jméno nebo login',
	));

	$f->input(array(
		"name"     => 'roles',
		"label"    => l('impro_team_member_roles'),
		"type"     => 'checkbox',
		"multiple" => true,
		"options"  => $roles,
	));


	$f->submit(l('godmode_add'));

	if ($f->passed()) {

		$p = $f->get_data();

		foreach ($p['users'] as $user_id) {
			$utest = $team->members->where(array("id_system_user" => $user_id))->paginate(1)->fetch();
			if (any($utest)) {
				$member = reset($utest);
				$member->roles = $p['roles'];
				$member->save();
			} else {
				$u = create("\Impro\Team\Member", array(
					"id_system_user" => $user_id,
					"id_impro_team"  => $team->id,
					"roles"          => $p['roles'],
				));
			}
		}

		redirect(soprintf($redirect, $team));

	} else {
		$f->out($this);
	}
}
