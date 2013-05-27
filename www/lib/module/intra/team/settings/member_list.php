<?

def($template, 'intra/team/settings/member_list');

if ($propagated['team']) {

	$team = &$propagated['team'];
	$members = $team->members->fetch();

	$this->partial($template, array(
		"members" => $members,
		"team"    => $team,
	));


} else throw new \System\Error\NotFound();
