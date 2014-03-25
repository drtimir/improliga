<?

def($id);
def($new, false);

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {
	$default = $event->get_data();
	$default['cancel'] = $default['prev'] = true;

	$f = $ren->form(array(
		"class"   => 'event_wizzard',
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_teams'),
		"default" => $default,
	));

	if ($event->type === Impro\Event\Type::ID_MATCH) {
		$teams = get_all('\Impro\Team')->where(array("visible" => true))->sort_by('name')->fetch();

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_home',
			"options"  => $teams,
			"label"    => $locales->trans('impro_event_team_home'),
			"required" => true,
		));

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_away',
			"options"  => $teams,
			"label"    => $locales->trans('impro_event_team_away'),
			"required" => true,
		));

		$f->text('hint0', $locales->trans('impro_event_wizzard_teams_hint'));

	} else {

		if (count($request->user()->teams)) {
			$teams = $request->user()->teams;
		} else {
			$teams = get_all('\Impro\Team')->where(array("visible" => true))->sort_by('name')->fetch();
		}

		$f->input(array(
			"type"     => 'select',
			"name"     => 'id_team_home',
			"options"  => $teams,
			"label"    => $locales->trans('impro_event_team_owner'),
			"required" => true,
		));

		$f->text('hint0', $locales->trans('impro_event_wizzard_team_owner_hint'));
	}

	$f->input_submit('prev', $locales->trans('impro_event_wizzard_prev'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));
	$f->submit($locales->trans('impro_event_wizzard_next'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
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
