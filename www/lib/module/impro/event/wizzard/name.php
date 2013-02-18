<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();
	$f = new System\Form(array(
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard", l('impro_event_wizzard_step_name')),
		"default" => $data
	));

	$f->input_text('name', l('impro_event_name'), true);
	$f->input(array(
		"type"    => 'select',
		"name"    => 'id_impro_event_type',
		"options" => Impro\Event\Type::get_all(),
		"label"   => l('impro_event_type')
	));

	$f->submit(l('impro_event_wizzard_next'));

	if ($f->passed()) {
		$event->update_attrs($f->get_data())->save();
		redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_TIMESPACE)));
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_NAME;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

