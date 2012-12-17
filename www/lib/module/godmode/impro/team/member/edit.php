<?

def($id);
def($team_id);
def($redirect, '/god/impro/teams/{id_impro_team}/');

if ($team_id && $team = find("\Impro\Team", $team_id)) {
	if ($id && $member = $team->members->where(array("id_system_user" => $id))->fetch_one()) {

		$roles = Impro\Team\Member\Role::get_all();

		$f = new System\Form(array(
			"heading" => l('godmode_add_player_to_team'),
			"default" => $member->get_data(),
		));

		$f->text(l("godmode_user_name"), $member->get_name());

		$f->input(array(
			"name"     => 'roles',
			"label"    => l('impro_team_member_roles'),
			"type"     => 'checkbox',
			"multiple" => true,
			"options"  => $roles,
		));


		$f->submit(l('godmode_save'));

		if ($f->passed()) {

			$p = $f->get_data();
			$member->roles = $p['roles'];
			$member->save();

			redirect(soprintf($redirect, $team));

		} else {
			$f->out($this);
		}
	}
}
