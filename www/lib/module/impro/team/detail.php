<?

$this->req('id');

def($template, 'impro/team/detail');

if ($team = find('Impro\Team', $id)) {


	$this->template($template, array(
		"team" => $team,
	));
}
