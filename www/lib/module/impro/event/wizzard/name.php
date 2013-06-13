<?

def($id);
def($new, false);


if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$data = $event->get_data();
	$f = $ren->form(array(
		"class"   => 'event_wizzard',
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_name'),
		"default" => $data
	));

	$f->input_text('name', $locales->trans('impro_event_name'), true);
	$f->text('hint1', $locales->trans('impro_event_wizzard_name_hint'));

	$f->input(array(
		"type"    => 'select',
		"name"    => 'type',
		"options" => Impro\Event\Type::get_all(),
		"label"   => $locales->trans('impro_event_type'),
		"required" => true,
	));
	$f->text('hint2', $locales->trans('impro_event_wizzard_type_hint'));

	$f->submit($locales->trans('impro_event_wizzard_next'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['cancel'])) {
			redirect_now(stprintf($link_wizzard, array("id_impro_event" => $event->id, "step" => Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->update_attrs($p);

			if ($event->type !== Impro\Event\Type::ID_MATCH) {
				$event->has_kazoo = Impro\Event::ID_SETUP_STATUS_NOT_NEEDED;
				$event->has_dress_ref = Impro\Event::ID_SETUP_STATUS_NOT_NEEDED;
				$event->has_dress_oth = Impro\Event::ID_SETUP_STATUS_NOT_NEEDED;
			}

			$event->save();
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_TEAMS)));
		}
	} else {
		$f->out($this);
	}

	$this->propagate('event', $event);
	$this->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_NAME);
} else throw new System\Error\AccessDenied();

