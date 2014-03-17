<?

def($new, false);
def($id);
def($redirect, '/god/impro/events/{id_impro_event}/');
def($heading, $new ? l('impro_event_create'):l('impro_event_delete'));


if (($new && $item = new Impro\Event()) || ($id && $item = find("\Impro\Event", $id))) {

	$teams = get_all('\Impro\Team')->where(array("visible" => true))->fetch();
	$teams_opts = array();

	foreach ($teams as $team) {
		$teams_opts[$team->name] = $team->id;
	}

	$data = $item->get_data();
	$data['location'] = $item->location;

	$f = new System\Form(array(
		"default" => $data,
		"heading" => $heading
	));

	$f->input_text("name", l('godmode_event_name'), true);
	$f->input(array(
		"type"    => 'select',
		"name"    => 'type',
		"options" => Impro\Event\Type::get_all(),
		"label"   => l('impro_event_type')
	));

	$f->input(array(
		"type"    => 'select',
		"name"    => 'id_team_home',
		"options" => $teams_opts,
		"label"   => l('impro_event_team_home'),
	));

	$f->input(array(
		"type"    => 'select',
		"name"    => 'id_team_away',
		"options" => $teams_opts,
		"label"   => l('impro_event_team_away'),
	));

	$f->input_datetime("start", l('impro_event_start'), true);
	$f->input_datetime("end", l('impro_event_end'), true);

	$f->input(array(
		"name"  => 'location',
		"type"  => 'location',
		"label" => l('impro_event_location'),
		"required" => true,
	));

	$f->input_image('image', l('impro_event_image'), false);

	$f->input_textarea('desc_short', l('impro_event_desc_short'), false);
	$f->input_textarea('desc_full', l('impro_event_desc_full'), false);
	$f->input_checkbox("visible", l('godmode_visible'), false, l('visible_hint'));

	$f->submit(l($new ? 'impro_event_create':'impro_event_edit'));

	if ($f->passed()) {
		$p = $f->get_data();

		$item->id_location = $p['location']->save()->id;
		$item->update_attrs($p)->save();
		redirect(soprintf($redirect, $item));

	} else {
		$f->out($this);
	}
}

