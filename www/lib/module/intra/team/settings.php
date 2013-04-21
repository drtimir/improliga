<?

def($link_redirect, '/teams/{seoname}/');

if (isset($propagated['team'])) {

	$team = &$propagated['team'];
	$data = $team->get_data();
	$data['hq'] = $team->hq;

	$f = new \System\Form(array(
		"default" => $data,
		"class"   => 'team_settings'
	));

	$f->input_text("name", l('attr_impro_team_name'), true);
	$f->input_text("name_full", l('attr_impro_team_name_full'), true);
	$f->input_text("city", l('attr_impro_team_city'), true);

	$f->input_image('logo', l('attr_impro_team_logo'));
	$f->input_image('photo', l('attr_impro_team_photo'));
	$f->input_rte('about', l('attr_impro_team_about'));

	$f->input_email("mail", l('attr_impro_team_mail'));
	$f->input_url("site", l('attr_impro_team_site'));

	$f->input_location("hq", l('attr_impro_team_hq'));

	$f->submit(l('godmode_save'));

	if ($f->passed()) {

		$p = $f->get_data();

		$team->update_attrs($p);

		if ($p['hq']) {
			$p['hq']->save();
			$team->id_hq = $p['hq']->id;
		}

		if ($team->save()) {
			redirect(soprintf($link_redirect, $team));
		}

	} else {
		$f->out($this);
	}

} else throw new \System\Error\NotFound();
