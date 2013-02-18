<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();
	$data['location'] = $event->location;

	$f = new System\Form(array(
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard", l('impro_event_wizzard_step_timespace')),
		"default" => $data
	));

	$f->input(array(
		"name"  => 'location',
		"type"  => 'location',
		"label" => l('impro_event_location'),
		"required" => true,
	));

	$f->input_datetime("start", l('impro_event_start'), true);

	if (in_array($event->id_impro_event_type, Impro\Event\Type::get_types_with_end())) {
		$f->input_datetime("end", l('impro_event_end'), true);
	}

	$f->submit(l('impro_event_wizzard_next'));

	if ($f->passed()) {
		$p = $f->get_data();
		$event->id_location = $p['location']->save()->id;
		$event->update_attrs($p)->save();
		redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_TEAMS)));
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_TIMESPACE;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

