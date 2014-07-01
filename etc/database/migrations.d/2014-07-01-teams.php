<?

$teams = get_all('\Impro\Team')->where(array('visible' => true))->fetch();

foreach ($teams as $team) {
	$team->published = true;
	$team->save();
}
