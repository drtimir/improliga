<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();

	$f = new System\Form(array(
		"class"   => array('event_wizzard', 'event_poster'),
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_poster'),
		"default" => $data
	));

	$f->input_number('price', l('impro_event_price'));
	$f->input_number('price_student', l('impro_event_price_student'));

	$f->input_checkbox('use_booking', l('impro_event_use_booking'));
	$f->text('hint1', l('impro_event_wizzard_use_booking_hint'));

	$f->text('hint0', l('impro_event_wizzard_poster_hint'));

	$f->input(array(
		"type"  => 'image',
		"name"  => 'image',
		"label" => l('impro_event_image'),
		"hint"  => l('impro_event_image_hint'),
		"required" => true,
	));

	$f->input_checkbox('generic_poster', l('impro_event_generic_poster'));
	$f->text('hint2', l('impro_event_wizzard_generic_poster_hint'));
	$f->input_checkbox('generic_tickets', l('impro_event_generic_tickets'));
	$f->text('hint3', l('impro_event_wizzard_generic_tickets_hint'));


	$f->submit(l('impro_event_wizzard_next'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("step" => 'cancel')));
		} else {
			$event->update_attrs($p);
			$event->save();
			redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_PUBLISH)));
		}
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

