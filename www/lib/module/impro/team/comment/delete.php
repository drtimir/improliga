<?

$this->req('id');

if (any($propagated['team']) && $team = $propagated['team']) {

	$member = $propagated['member'];
	$has_right = $member && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE);
	if ($post = find('Impro\Team\Comment', $id)) {

		if ($post->id_author == $request->user->id || $has_right) {

			$f = $ren->form_checker(array(
				"heading" => $ren->trans('impro_team_comment_delete'),
				"desc"    => $ren->trans('impro_team_comment_delete_desc', $post->author ? Impro\User::link($ren, $post->author):'anonym'),
				"info"    => array()
			));

			$f->out();

			if ($f->passed()) {
				$post->drop();
				$flow->redirect($ren->url('team', array($team)));
			}
		} else throw new \System\Error\AccessDenied();
	} else throw new \System\Error\NotFound();
} else throw new \System\Error\NotFound();


