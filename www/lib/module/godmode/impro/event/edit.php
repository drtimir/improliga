<?

def($new, false);
def($id);
def($redirect, '/god/impro/event/{id_impro_event}/edit/');
def($heading, $new ? l('godmode_match_create'):l('godmode_match_delete'));


if (($new && $item = new Impro\Match()) || ($id && $item = find("\Impro\Match", $id))) {

	$f = new System\Form(array("default" => $item->get_data(), "heading" => $heading));
	$f->input_text("name", l('godmode_event_name'), true);
	$f->input_datetime("start", l('godmode_event_start'), true);
	$f->input_file('image', l('godmode_event_image'), true);

	$f->input(array(
		"type"  => 'textarea',
		"name"  => 'desc_short',
		"label" => l('godmode_event_desc_short'),
		"required" => true,
	));

	$f->input(array(
		"type" => 'textarea',
		"name" => 'desc_full',
		"label" => l('godmode_event_desc_full'),
		"required" => true,
	));

	$f->input_checkbox("visible", l('godmode_event_visible'));
	$f->input_checkbox("published", l('godmode_event_published'));

	$f->submit(l($new ? 'godmode_event_create':'godmode_event_edit'));

	$f->out($this);

}

