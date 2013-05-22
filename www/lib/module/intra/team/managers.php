<?

def($template, 'intra/team/people');
def($link_user, '/profile/{seoname}/');
def($heading, l('impro_team_managers'));

if (isset($propagated['team'])) {

	$people = $team->get_leaders();

	$this->partial($template, array(
		"team"      => $team,
		"people"    => $people,
		"link_user" => $link_user,
		"heading"   => $heading,
	));

} else throw new \System\Error\NotFound();
