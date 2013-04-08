<?

def($template, 'intra/team/people');
def($link_user, '/profile/{seoname}/');

if (isset($propagated['team'])) {

	$people = $team->get_leaders();

	$this->template($template, array(
		"team"      => $team,
		"people"    => $people,
		"link_user" => $link_user,
	));

} else throw new \System\Error\NotFound();
