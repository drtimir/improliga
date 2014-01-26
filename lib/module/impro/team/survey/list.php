<?

if (isset($propagated['team']) && $team = $propagated['team']) {

	$team = $propagated['team'];

	$surveys = $team
		->surveys
		->where(array(array('t0.end_at < NOW()', 'ISNULL(t0.end_at)')))
		->where(array(
			"visible" => true,
		))->fetch();

	$this->partial('impro/team/survey/list', array(
		"team" => $team,
		"surveys" => $surveys,
	));

} else throw new \System\Error\NotFound();
