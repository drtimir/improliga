<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');
def($link_event, '/events/{id_impro_event}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();
	$f = new System\Form(array(
		"class"   => array('event_wizzard', 'event_publish'),
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_publish'),
		"default" => $data
	));

	$f->input_checkbox('visible', l('impro_event_visible'));
	$f->text('hint0', l('impro_event_wizzard_visible_hint'));

	//~ if (user()->has_right)

	if (user()->has_right_to('publish_event')) {
		$f->input(array(
			"type" => 'checkbox',
			"name" => 'published',
			"label" => l('impro_event_publish'),
		));

		$f->text('hint1', l('impro_event_wizzard_published_hint'));
	} else {
		$f->input(array(
			"type" => 'checkbox',
			"name" => 'publish_wait',
			"label" => l('impro_event_publish_queue'),
		));

		$f->text('hint1', l('impro_event_wizzard_published_rights_hint'));
	}

	$f->submit(l('impro_event_wizzard_finish'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->update_attrs($p);
			$event->save();

			Impro\Event::free_wizzard();
			redirect_now(soprintf($link_event, $event));
		}
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_PUBLISH;
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

