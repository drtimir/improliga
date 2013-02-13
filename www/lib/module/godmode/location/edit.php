<?

def($new, false);
def($id);
def($redirect, '/god/locations/{id_system_location}/edit/');

if (($new && $text = new System\Location()) || ($id && $text = find("\System\Location", $id))) {

	$dd = $text->get_data();
	$heading = $new ? l('godmode_location_create'):l('godmode_location_edit');

	$f = new System\Form(array(
		"default" => $dd,
		"id" => 'edit-text',
		"heading" => $heading,
		"class" => array('input-location'),
	));

	$f->input_text('name', l('godmode_name'), true);
	$f->input_text('addr', l('godmode_address'), true);
	$f->input_text('site', l('godmode_site'));
	$f->input_gps('gps', l('godmode_location_gps'), true);
	$f->submit(l('godmode_save'));

	if ($f->passed()) {

		$p = $f->get_data();
		$text->update_attrs($p)->save();

		if (!$text->errors()) {
			message('success', $heading, l('godmode_save_success'), true);
			redirect(soprintf($redirect, $text));
		}
	}

	if (!$f->passed() || $text->errors()) {
		if ($text->errors()) {
			message('error', $heading, System\Locales::sysmsg($text->errors()));
		}

		$f->out($this);
	}

} else throw new \System\Error\NotFound();
