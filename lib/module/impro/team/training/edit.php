<?

def($new, false);
$model = '\Impro\Team\Training';

if (isset($propagated['team']) && $team = $propagated['team']) {

	if ($team->use_attendance) {

		$member = $team->member($request->user());
		if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ORGANIZE)) {
			if ($new) {
				$trn = new $model(array(
					"author" => $request->user(),
					"team"   => $team,
				));
			} else {
				$trn = find($model, $id);
			}

			$default = $trn->get_data();

			if ($new && $team->loc_trainings) {
				$default['location'] = $team->loc_trainings;
				$trn->location = $team->loc_trainings;
			} else {
				$default['location'] = $trn->location;
			}

			$f = $ren->form(array(
				"default" => $default,
				"class" => 'tgform',
			));


			$f->input_datetime('start',$locales->trans_model_attr_name($model, 'start'), true);
			$f->input_text('name', $locales->trans_model_attr_name($model, 'name'), false, $locales->trans_model_attr_desc($model, 'name'));
			$f->input(array(
				"name" => 'open',
				"type" => 'radio',
				"label" => $locales->trans_model_attr_name($model, 'open'),
				"options" => array(
					true  => 'intra_tg_open',
					false => 'intra_tg_closed',
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
					$trn->name = $locales->trans($trn->open ? 'training_open':'training_closed');
				}

				$trn->save();

				if ($new) {
					$trn->send_invites($ren);
				}

				$flow->redirect($ren->url('team_training', array($team, $trn)));
			}
		} else throw new \System\Error\AccessDenied();
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
