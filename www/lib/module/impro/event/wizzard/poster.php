<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();

	$f = new System\Form(array(
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard", l('impro_event_wizzard_step_poster')),
		"default" => $data
	));

	$f->input(array(
		"type"  => 'image',
		"name"  => 'image',
		"label" => l('impro_event_image'),
		"hint"  => l('impro_event_image_hint')
	));

	$f->input_checkbox('generic_poster', l('impro_event_generic_poster'), false, l('impro_event_generic_poster_hint'));
	$f->input_checkbox('generic_tickets', l('impro_event_generic_tickets'), false, l('impro_event_generic_tickets_hint'));


	$f->submit(l('impro_event_wizzard_next'));

	if ($f->passed()) {
		$p = $f->get_data();
		$event->update_attrs($p);
		$event->save();
		redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_PUBLISH)));
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_POSTER;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

