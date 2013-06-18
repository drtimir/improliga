<?

$this->req('id');

if (any($propagated['team']) && $post = find(get_model('Impro\Team\Comment\Response'), $id)) {

	$team    = $propagated['team'];
	$member  = $propagated['member'];
	$has_right = $member && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE);

	if ($post->id_author == $request->user->id || $has_right) {

		$f = $ren->form_checker(array(
			"heading" => $ren->trans('impro_team_comment_delete'),
			"desc"    => $ren->trans('impro_team_comment_response_delete_desc', $post->author ? Impro\User::link($ren, $post->author):'anonym'),
			"info"    => array()
		));

		$f->out($this);

		if ($f->passed()) {
			$post->drop();
			$flow->redirect($ren->url('team_comment_respond', array($team, $post->comment)));
		}
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
