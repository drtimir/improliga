<?

def($id_team);
def($redirect, '/teams/{seoname}/');

if ((any($propagated['team']) && $team = $propagated['team']) || ($id_team && ($team = find('\Impro\Team', $id_team)))) {
	$f = $ren->form(array(
		"heading" => l('impro_team_comment_add'),
		"class"   => 'team_comment',
	));

	$f->input_rte('text', l('impro_team_comment_add'), true);
	$f->submit(l('impro_team_comment_add_short'));

	if ($f->passed()) {
		$p = $f->get_data();

		$c = new \Impro\Team\Comment($p);
		$c->id_team = $team->id;
		$c->visible = true;
		$c->id_user = $request->user()->id;

		if ($c->save()) {
			$flow->redirect($ren->url('team', array($team)));
		} else {
			$f->out($this);
		}

	} else {
		$f->out($this);
	}
} else throw new \System\Error\NotFound();

