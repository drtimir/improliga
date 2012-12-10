<?

def($id, null);

if ($id && ($team = find('\Impro\Team', $id))) {
	$this->template('godmode/impro/team/detail', array("team" => $team));
}
