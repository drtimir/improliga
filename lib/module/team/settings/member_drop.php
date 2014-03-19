<?

$this->req('id');

if ($id && ($item = find('\Impro\Team\Member', $id))) {

	$item->drop();
	$flow->redirect($ren->url('team_settings_members', array($item->team)));

} else throw new \System\Error\NotFound();
