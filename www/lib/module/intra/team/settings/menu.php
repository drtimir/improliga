<?


if (isset($propagated['team'])) {

	$this->partial('intra/team/settings/menu', array(
		"team" => $propagated['team'],
	));

}
