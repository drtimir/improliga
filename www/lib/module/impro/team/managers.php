<?

def($template, 'intra/team/people');

if (isset($propagated['team'])) {

	$members = $team->members->fetch();
	$people  = array();

	foreach ($members as $member) {
	}


	$this->template($template, array(
		"team" => $team,
		"people" => $people,
	));

} else throw new \System\Error\NotFound();
