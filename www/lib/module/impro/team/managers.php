<?

def($template, 'impro/team/people');
def($heading, $locales->trans('impro_team_managers'));

if (isset($propagated['team'])) {

	$people = $team->get_leaders();

	$this->partial($template, array(
		"team"      => $team,
		"people"    => $people,
		"heading"   => $heading,
	));

} else throw new \System\Error\NotFound();
