<?

$this->req('id');
def($new, false);
def($heading, $locales->trans($new ? 'impro_discussion_topic_create':'impro_discussion_topic_edit'));
def($model, get_model('Impro\Team\Discussion\Topic'));


if (any($propagated['team']) && $team = $propagated['team'] && ($id && $topic = find($model, $id))) {
	$member = $propagated['member'];

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE) || $topic->author->id == $request->user->id) {

		$f = $ren->form_checker(array(
			"heading" => $ren->trans('intra_team_discussion_topic_delete'),
			"desc"    => $ren->trans('intra_team_discussion_topic_delete_desc', $topic->name),
			"info" => array()
		));

		$f->out($this);

		if ($f->passed()) {
			$topic->drop();
			$flow->redirect($ren->url('team_discussion', array($team)));
		}
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
