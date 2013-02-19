<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();
	$f = new System\Form(array(
		"class"   => 'event_wizzard',
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard"),
		"desc"    => t('impro_event_wizzard_step_name'),
		"default" => $data
	));

	$f->input_text('name', l('impro_event_name'), true);
	$f->text('hint1', l('impro_event_wizzard_name_hint'));

	$f->input(array(
		"type"    => 'select',
		"name"    => 'id_impro_event_type',
		"options" => Impro\Event\Type::get_all(),
		"label"   => l('impro_event_type'),
		"required" => true,
	));
	$f->text('hint2', l('impro_event_wizzard_type_hint'));

	$f->submit(l('impro_event_wizzard_next'));
	$f->input_submit('cancel', l('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("step" => 'cancel')));
		} else {
			$event->update_attrs($p);

			if ($event->id_impro_event_type !== Impro\Event\Type::ID_MATCH) {
				$event->has_kazoo = Impro\Event::ID_SETUP_STATUS_NOT_NEEDED;
				$event->has_dress_ref = Impro\Event::ID_SETUP_STATUS_NOT_NEEDED;
				$event->has_dress_oth = Impro\Event::ID_SETUP_STATUS_NOT_NEEDED;
			}

			$event->save();
			redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_TIMESPACE)));
		}
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

