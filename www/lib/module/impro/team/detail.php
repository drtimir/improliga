<?

$this->req('id');

def($template, 'impro/team/detail');

if ($team = find('Impro\Team', $id)) {

	System\Output::set_title($team->name);

	$this->template($template, array(
		"team" => $team,
	));
}
