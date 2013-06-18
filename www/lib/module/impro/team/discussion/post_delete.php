<?

def($id);
def($id_topic);

$model = get_model('Impro\Team\Discussion\Post');

if (any($propagated['team']) && $team = $propagated['team'] && ($id && $post = find($model, $id))) {
	$member = $propagated['member'];

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE) || $topic->author->id == $request->user->id) {

		$f = $ren->form_checker(array(
			"heading" => $ren->trans('intra_team_discussion_post_delete'),
			"desc"    => $ren->trans('intra_team_discussion_post_delete_desc'),
			"info" => array(
				"Autor" => \Impro\User::link($ren, $post->author),
				"Text" => $post->text,
			)
		));

		$f->out($this);

		if ($f->passed()) {
			$post->drop();
			$flow->redirect($ren->url('team_discussion_topic', array($team, $post->topic)));
		}
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
