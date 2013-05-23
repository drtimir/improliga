<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$f = $ren->form(array(
		"class"   => 'event_wizzard',
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_teams'),
		"default" => $event->get_data()
	));

	if ($event->type === Impro\Event\Type::ID_MATCH) {
		$teams = get_all('\Impro\Team')->where(array("visible" => true))->sort_by('name')->fetch();

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_home',
			"options"  => $teams,
			"label"    => l('impro_event_team_home'),
			"required" => true,
		));

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_away',
			"options"  => $teams,
			"label"    => l('impro_event_team_away'),
			"required" => true,
		));

		$f->text('hint0', l('impro_event_wizzard_teams_hint'));

	} else {

		if (!empty(user()->teams)) {
			$teams = user()->teams;
		} else {
			$teams = get_all('\Impro\Team')->where(array("visible" => true))->sort_by('name')->fetch();
		}

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_home',
			"options"  => $teams,
			"label"    => l('impro_event_team_owner'),
			"required" => true,
		));

		$f->text('hint0', l('impro_event_wizzard_team_owner_hint'));
	}

	$f->submit(l('impro_event_wizzard_next'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_CANCEL)));

		} else {
			$p = $f->get_data();
			$event->update_attrs($p);

			if (!$event->id_location && $event->team_home->hq) {
				$event->id_location = $event->team_home->id_hq;
			}

			$event->save();
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_TIMESPACE)));
		}
	} else {
		$f->out($this);
	}

	$this->propagate('event', $event);
	$this->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_TEAMS);
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

