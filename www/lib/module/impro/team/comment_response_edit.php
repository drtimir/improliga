<?

def($redirect, "/teams/{seoname}/respond/{id_impro_team_comment}/");

if (any($propagated['comment']) && any($propagated['team'])) {

	$comment = $propagated['comment'];
	$team    = $propagated['team'];

	$f = new \System\Form(array(
		"class"   => 'team_comment team_response',
	));

	$f->input_rte('text', l('impro_team_comment_response'), true);
	$f->submit(l('impro_team_comment_respond'));

	if ($f->passed()) {
		$p = $f->get_data();

		$r = new \Impro\Team\Comment\Response($p);
		$r->id_user    = user()->id;
		$r->id_comment = $comment->id;
		$r->visible    = true;

		if ($r->save()) {

			redirect(soprintf(soprintf($redirect, $team), $comment));

		} else $f->out($this);
	} else $f->out($this);

} else throw new \System\Error\NotFound();
