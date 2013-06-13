<?

def($id);
def($new, false);

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$data = $event->get_data();
	$f = $ren->form_checker(array(
		"info" => array(
			$locales->trans('impro_event_name').':' => $event->name,
		),
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_cancel'),
		"default" => $data,
		"class" => array('event_wizzard', 'event_wizzard_cancel'),
	));

	if ($f->passed()) {
		$event->drop();
		$flow->redirect($ren->url('profile_events'));
	} else {
		$f->out($this);
	}

	$this->propagate('event', $event);
	$this->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_CANCEL);
} else throw new System\Error\AccessDenied();

