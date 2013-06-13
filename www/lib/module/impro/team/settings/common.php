<?

if (isset($propagated['team'])) {

	$team = &$propagated['team'];
	$member = $team->member($request->user());

	if ($member && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DATA)) {

		$data = $team->get_data();
		$data['hq'] = $team->hq;

		$f = $ren->form(array(
			"default" => $data,
			"class"   => 'team_settings'
		));

		$f->input_text("name", $locales->trans('attr_impro_team_name'), true);
		$f->input_text("name_full", $locales->trans('attr_impro_team_name_full'), true);
		$f->input_text("city", $locales->trans('attr_impro_team_city'), true);

		$f->input_image('logo', $locales->trans('attr_impro_team_logo'));
		$f->input_image('photo', $locales->trans('attr_impro_team_photo'));
		$f->input_rte('about', $locales->trans('attr_impro_team_about'));

		$f->input_email("mail", $locales->trans('attr_impro_team_mail'));
		$f->input_url("site", $locales->trans('attr_impro_team_site'));

		$f->input_location("hq", $locales->trans('attr_impro_team_hq'));

		$f->input_checkbox('use_attendance', $locales->trans_model_attr_name('Impro\Team', 'use_attendance'), false, $locales->trans_model_attr_desc('Impro\Team', 'use_attendance'));
		$f->input_checkbox('use_booking', $locales->trans_model_attr_name('Impro\Team', 'use_booking'), false, $locales->trans_model_attr_desc('Impro\Team', 'use_booking'));

		$f->submit($locales->trans('godmode_save'));

		if ($f->passed()) {

			$p = $f->get_data();

			$team->update_attrs($p);

			if ($p['hq']) {
				$p['hq']->save();
				$team->id_hq = $p['hq']->id;
			}

			if ($team->save()) {
				$flow->redirect($ren->url('team', array($team)));
			}

		} else {
			$f->out($this);
		}
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
