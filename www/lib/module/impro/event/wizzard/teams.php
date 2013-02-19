<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$f = new System\Form(array(
		"class"   => 'event_wizzard',
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_teams'),
		"default" => $event->get_data()
	));

	if ($event->id_impro_event_type === Impro\Event\Type::ID_MATCH) {
		$teams = get_all('\Impro\Team')->where(array("visible" => true))->sort_by('name')->fetch();
		$teams_opts = array();

		foreach ($teams as $team) {
			$teams_opts[$team->name] = $team->id;
		}

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_home',
			"options"  => $teams_opts,
			"label"    => l('impro_event_team_home'),
			"required" => true,
		));

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_away',
			"options"  => $teams_opts,
			"label"    => l('impro_event_team_away'),
			"required" => true,
		));

		$f->text('hint0', l('impro_event_wizzard_teams_hint'));

	} else {

		$teams = user()->teams;
		$teams_opts = array();

		foreach ($teams as $team) {
			$teams_opts[$team->name] = $team->id;
		}

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_home',
			"options"  => $teams_opts,
			"label"    => l('impro_event_team_owner'),
			"required" => true,
		));

		$f->text('hint0', l('impro_event_wizzard_team_owner_hint'));
	}

	$f->submit(l('impro_event_wizzard_next'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("step" => 'cancel')));
		} else {
			$p = $f->get_data();
			$event->update_attrs($p)->save();
			redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_PARTICIPANTS)));
		}
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_TEAMS;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

