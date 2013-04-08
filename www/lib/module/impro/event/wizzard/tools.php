<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();
	$f = new System\Form(array(
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_tools'),
		"default" => $data,
		"class"   => array('event_wizzard', 'event_tools'),
	));

	$f->text('hint0', l('impro_event_wizzard_tools_hint'));

	$opts = array(
		Impro\Event::ID_SETUP_STATUS_NO => l('impro_setup_status_no'),
		Impro\Event::ID_SETUP_STATUS_OK => l('impro_setup_status_ok'),
		Impro\Event::ID_SETUP_STATUS_NOT_NEEDED => l('impro_setup_status_not_needed'),
	);

	foreach (Impro\Event::get_tools() as $tool) {
		$f->input(array(
			"type"    => 'radio',
			"name"    => 'has_'.$tool,
			"label"   => l('impro_event_tools_'.$tool),
			"options" => $opts,
			"multiple" => true,
		));
	}

	$f->text('hint1', l('impro_event_wizzard_tools_hint_lower'));
	$f->submit(l('impro_event_wizzard_next'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->update_attrs($p)->save();
			redirect(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_POSTER)));
		}
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_TOOLS;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

