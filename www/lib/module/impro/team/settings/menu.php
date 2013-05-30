<?


if (isset($propagated['team'])) {

	$this->partial('impro/team/settings/menu', array(
		"team" => $propagated['team'],
	));

}
