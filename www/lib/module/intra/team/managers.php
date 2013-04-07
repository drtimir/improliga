<?

def($template, 'intra/team/people');
def($link_user, '/profile/{seoname}/');

if (isset($propagated['team'])) {

	$members = $team->members->fetch();
	$roles   = \Impro\Team\Member\Role::get_manager_roles();
	$people  = array();

	foreach ($members as $member) {
		foreach ($member->roles as $role) {
			if (in_array($role, $roles)) {
				$people[] = $member;
				break;
			}
		}
	}

	$this->template($template, array(
		"team"      => $team,
		"people"    => $people,
		"link_user" => $link_user,
	));

} else throw new \System\Error\NotFound();
