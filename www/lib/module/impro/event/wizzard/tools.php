<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$data = $event->get_data();
	$f = $ren->form(array(
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_tools'),
		"default" => $data,
		"class"   => array('event_wizzard', 'event_tools'),
	));

	$f->text('hint0', $locales->trans('impro_event_wizzard_tools_hint'));

	$opts = array(
		Impro\Event::ID_SETUP_STATUS_NO => $locales->trans('impro_setup_status_no'),
		Impro\Event::ID_SETUP_STATUS_OK => $locales->trans('impro_setup_status_ok'),
		Impro\Event::ID_SETUP_STATUS_NOT_NEEDED => $locales->trans('impro_setup_status_not_needed'),
	);

	foreach (Impro\Event::get_tools() as $tool) {
		$f->input(array(
			"type"    => 'radio',
			"name"    => 'has_'.$tool,
			"label"   => $locales->trans('impro_event_tools_'.$tool),
			"options" => $opts,
			"multiple" => true,
		));
	}

	$f->text('hint1', $locales->trans('impro_event_wizzard_tools_hint_lower'));
	$f->submit($locales->trans('impro_event_wizzard_next'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->update_attrs($p)->save();
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_POSTER)));
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

