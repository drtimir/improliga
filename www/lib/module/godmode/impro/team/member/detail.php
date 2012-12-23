<?

def($id);
def($team_id);
def($redirect, '/god/impro/teams/{id_impro_team}/');

if ($team_id && $team = find("\Impro\Team", $team_id)) {
	if ($id && $member = $team->members->where(array("id_system_user" => $id))->fetch_one()) {

		$other = get_all('\Impro\Team\Member')->where(array("id_system_user" => $id))->fetch();

		foreach ($other as $key=>$mem) {
			if ($mem->id_impro_team == $team_id) {
				unset($other[$key]);
			}
		}


		$this->template("godmode/impro/team/detail_member", array(
			"user"  => $member->user,
			"team"  => $team,
			"other" => $other,
		));
	}
}
