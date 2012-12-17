<?

def($id);
def($team_id);
def($redirect, '/god/impro/teams/{id_impro_team}/');
def($heading, l('godmode_delete_team_member'));

if ($team_id && $team = find("\Impro\Team", $team_id)) {
	if ($id && $member = $team->members->where(array("id_system_user" => $id))->fetch_one()) {

		$f = System\Form::create_delete_checker(array(
			"submit" => l('godmode_delete'),
			"heading" => $heading,
			"info" => array(
				l('godmode_user_name')  => $member->get_name(),
			),
		));

		if ($f->passed()) {

			$member->drop() ?
				message('success', $heading, l('godmode_delete_success')):
				message('error', $heading, l('godmode_delete_fail'));

			redirect(soprintf($link_cont, $member));

		} else $f->out($this);
	}
}
