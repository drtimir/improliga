<?

def($id);
def($new, false);

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$data = $event->get_data();
	$data['location'] = $event->location;

	$f = $ren->form(array(
		"class"   => 'event_wizzard event_timespace',
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_timespace'),
		"default" => $data,
	));

	$f->input_datetime("start", $locales->trans('impro_event_start'), true);
	$f->text('hint0', $locales->trans('impro_event_wizzard_start_hint'));

	if (in_array($event->type, Impro\Event\Type::get_types_with_end())) {
		$f->input_datetime("end", $locales->trans('impro_event_end'), true);
		$f->text('hint1', $locales->trans('impro_event_wizzard_end_hint'));
	}

	$f->input_location('location', $locales->trans('impro_event_location'), true);

	$f->text('hint2', $locales->trans('impro_event_wizzard_location_hint'));
	$f->submit($locales->trans('impro_event_wizzard_next'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->id_location = $p['location']->save()->id;
			$event->update_attrs($p)->save();
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_PARTICIPANTS)));
		}
	} else {
		$f->out($this);
	}

	$module->propagate('event', $event);
	$module->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_TIMESPACE);
} else throw new System\Error\AccessDenied();
