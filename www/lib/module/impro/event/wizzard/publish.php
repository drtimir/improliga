<?

def($id);
def($new, false);

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$data = $event->get_data();
	$f = $ren->form(array(
		"class"   => array('event_wizzard', 'event_publish'),
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_publish'),
		"default" => $data,
	));

	$f->input_checkbox('visible', $locales->trans('impro_event_visible'));
	$f->text('hint0', $locales->trans('impro_event_wizzard_visible_hint'));

	//~ if (user()->has_right)

	if ($request->user()->has_right('publish_event')) {
		$f->input(array(
			"type" => 'checkbox',
			"name" => 'published',
			"label" => $locales->trans('impro_event_publish'),
		));

		$f->text('hint1', $locales->trans('impro_event_wizzard_published_hint'));
	} else {
		$f->input(array(
			"type" => 'checkbox',
			"name" => 'publish_wait',
			"label" => $locales->trans('impro_event_publish_queue'),
		));

		$f->text('hint1', $locales->trans('impro_event_wizzard_published_rights_hint'));
	}

	$f->submit($locales->trans('impro_event_wizzard_finish'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->update_attrs($p);
			$event->save();

			Impro\Event::free_wizzard();
			$flow->redirect($ren->url('event', array($event)));
		}
	} else {
		$f->out($this);
	}

	$this->propagate('event', $event);
	$this->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_PUBLISH);
} else throw new System\Error\AccessDenied();


//~ Název, Typ
//~ Místo, Datum a čas
//~ Týmy
//~ Hráči, Rozhodčí, Konferenciér, Hudebníci, Technici, Pomocňáci
//~ Píšťalka, Kazoo, Mikrofony, Dresy rozhodčích, Hlasovací kartičky, Košík na témata, Papíry a tužky
//~ Plakát, Vstupenky
//~ Zveřejnění

