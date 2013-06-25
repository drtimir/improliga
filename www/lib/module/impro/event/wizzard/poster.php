<?

def($id);
def($new, false);

if ($event = Impro\Event::wizzard_for($request->user(), $id, $new)) {

	$data = $event->get_data();
	$data['generate_poster'] = true;
	$data['button_prev'] = true;
	$data['button_cancel'] = true;

	$f = $ren->form(array(
		"class"   => array('event_wizzard', 'event_poster'),
		"heading" => $locales->trans("impro_event_wizzard"),
		"desc"    => $locales->trans('impro_event_wizzard_step_poster'),
		"default" => $data
	));

	$f->input_number('price', $locales->trans('impro_event_price'));
	$f->input_number('price_student', $locales->trans('impro_event_price_student'));

	$f->input_checkbox('use_booking', $locales->trans('impro_event_use_booking'));
	$f->text('hint1', $locales->trans('impro_event_wizzard_use_booking_hint'));

	$f->text('hint0', $locales->trans('impro_event_wizzard_poster_hint'));

	$f->input(array(
		"type"  => 'image',
		"name"  => 'image',
		"label" => $locales->trans('impro_event_image'),
		"hint"  => $locales->trans('impro_event_image_hint'),
		"required" => true,
	));

	$f->input_checkbox('generic_tickets', $locales->trans('impro_event_generic_tickets'));
	$f->text('hint3', $locales->trans('impro_event_wizzard_generic_tickets_hint'));

	$f->input_submit('prev', $locales->trans('impro_event_wizzard_prev'));
	$f->input_submit('cancel', $locales->trans('impro_event_wizzard_cancel'));
	$f->input_submit('generate_poster', $locales->trans('impro_event_generic_poster'));
	$f->submit($locales->trans('impro_event_wizzard_next'));

	if ($f->passed()) {
		$p = $f->get_data();

		if (isset($p['generate_poster'])) {
			$poster = \Impro\Event\Poster::generate($ren, $event);
			v($poster);
			exit;
		} else if (isset($p['cancel'])) {
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_CANCEL)));
		} else {
			$event->update_attrs($p);
			$event->save();
			$flow->redirect($ren->url('event_edit_step', array($event, Impro\Event::ID_WIZZARD_STEP_PUBLISH)));
		}
	} else {
		$f->out($this);
	}

	$this->propagate('event', $event);
	$this->propagate('wizzard_step', Impro\Event::ID_WIZZARD_STEP_POSTER);
} else throw new System\Error\AccessDenied();
