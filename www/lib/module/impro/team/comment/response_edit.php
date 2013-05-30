<?

if (any($propagated['comment']) && any($propagated['team'])) {

	$comment = $propagated['comment'];
	$team    = $propagated['team'];

	$f = $ren->form(array(
		"class" => 'team_comment team_response',
	));

	$f->input_rte('text', l('impro_team_comment_response'), true);
	$f->submit(l('impro_team_comment_respond'));

	if ($f->passed()) {
		$p = $f->get_data();

		$r = new \Impro\Team\Comment\Response($p);
		$r->id_user    = $request->user()->id;
		$r->id_comment = $comment->id;
		$r->visible    = true;

		if ($r->save()) {
			$r->mail($ren);
			$flow->redirect($ren->url('team_comment_respond', array($team, $comment)));

		} else $f->out($this);
	} else $f->out($this);

} else throw new \System\Error\NotFound();
