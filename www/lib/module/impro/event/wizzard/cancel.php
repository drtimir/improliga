<?

def($id);
def($new, false);
def($link_wizzard, '/events/create/{step}/');

if ($event = Impro\Event::wizzard_for($id, $new)) {

	$data = $event->get_data();
	$f = System\Form::create_delete_checker(array(
		"action"  => intra_path(),
		"heading" => t("impro_event_wizzard", l('impro_event_wizzard_step_name')),
		"default" => $data
	));

	if ($f->passed()) {
		$event->update_attrs($f->get_data())->save();
		redirect(stprintf($link_wizzard, array("step" => Impro\Event::ID_WIZZARD_STEP_TIMESPACE)));
	} else {
		$f->out($this);
	}

	$propagate['event'] = $event;
	$propagate['wizzard_step'] = Impro\Event::ID_WIZZARD_STEP_NAME;
} else throw new System\Error\AccessDenied();

