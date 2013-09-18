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

		$c = new \Impro\Post($p);
		$c->team    = $team;
		$c->visible = true;
		$c->author  = $request->user;

		if ($c->save()) {
			$mail_opts = array(
				"id_author" => $request->user->id,
				"redirect"  => $ren->uri('team_comment_respond', array($team, $c)),
				"text"      => stprintf($ren->trans('intra_team_comment_new_text'), array(
					"text"      => to_html($ren, $c->text),
					"user_name" => \Impro\User::link($ren, $c->author),
					"team_name" => $team->to_html_link($ren),
				)),
			);

			$team->mail_to($ren, $mail_opts);
			$flow->redirect($ren->url('team', array($team)));
		}
	}
} else throw new \System\Error\NotFound();

