<?

def($id_team);
def($template, 'intra/team/people');
def($link_user, '/profile/{seoname}/');
def($heading, l('impro_team_members'));

if ((any($propagated['team']) && ($team = $propagated['team'])) || $id_team && ($team = find('\Impro\Team', $id_team))) {
	$people = $team->members->fetch();

	$this->partial($template, array(
		"people"    => $people,
		"link_user" => $link_user,
		"heading"   => $heading,
	));
}
