<?

if (any($propagated['team']) && $team = $propagated['team']) {
	$f = $ren->form(array(
		"heading" => $locales->trans('impro_team_comment_add'),
		"class"   => 'team_comment',
	));

	$f->input_rte('text', $locales->trans('impro_team_comment_add'), true);
	$f->submit($locales->trans('impro_team_comment_add_short'));
	$f->out($this);

	if ($f->passed()) {
		$p = $f->get_data();

		$c = new \Impro\Team\Comment($p);
		$c->team    = $team;
		$c->visible = true;
		$c->author  = $request->user;

		if ($c->save()) {
			$c->mail($ren);
			$flow->redirect($ren->url('team', array($team)));
		}
	}
} else throw new \System\Error\NotFound();

