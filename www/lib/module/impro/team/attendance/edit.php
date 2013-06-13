<?

def($new, false);
$model = '\Impro\Team\Training';

if (isset($propagated['team']) && $team = $propagated['team']) {

	if ($new) {
		$trn = new $model(array(
			"author" => $request->user(),
			"team"   => $team,
		));
	} else {
		$trn = find($model, $id);
	}

	$f = $ren->form(array(
		"default" => $trn->get_data()
	));


	$f->input_text('name', $locales->trans_model_attr_name($model, 'name'));
	$f->input_datetime('start',$locales->trans_model_attr_name($model, 'start'), true);
	$f->input(array(
		"name" => 'open',
		"type" => 'radio',
		"multiple" => true,
		"label" => $locales->trans_model_attr_name($model, 'open'),
		"options" => array(
			true  => 'open',
			false => 'closed',
		),
	));

	$f->input_rte('desc', $locales->trans_model_attr_name($model, 'desc'));
	$f->input_location('location', $locales->trans_model_attr_name($model, 'location'));
	$f->submit($locales->trans($new ? 'godmode_create':'godmode_edit'));

	$f->out($this);

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['location'])) {
			if (any($p['location'])) {
				$p['location']->save();
			}
		}

		if (is_null($p['location'])) {
			unset($p['location']);
		}

		$trn->update_attrs($p);

		if (!$trn->name) {
			$trn->name = $locales->trans($trn->open ? 'intra_team_training_open':'intra_team_training_closed');
		}

		$trn->save();

		if ($new) {
			$trn->send_invites($ren);
		}

		$flow->redirect($ren->url('team_attendance', array($team)));
	}

} else throw new \System\Error\NotFound();
