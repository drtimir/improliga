<?

def($template, 'intra/team/info');

if (isset($propagated['team'])) {

	$this->template($template, array(
		"team" => $team,
	));

} else throw new \System\Error\NotFound();
