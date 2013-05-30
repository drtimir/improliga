<?

def($id_team);
def($template, 'impro/team/people');
def($heading, $locales->trans('impro_team_members'));

if ((any($propagated['team']) && ($team = $propagated['team'])) || $id_team && ($team = find('\Impro\Team', $id_team))) {
	$people = $team->members->fetch();

	$this->partial($template, array(
		"people"    => $people,
		"heading"   => $heading,
	));
}
