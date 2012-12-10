<?

def($new, false);
def($id);
def($redirect, '/god/texts/{id_system_text}/edit/');

if (($new && $text = new System\Text()) || ($id && $text = find("\System\Text", $id))) {

	$dd = $text->get_data();
	$heading = $new ? l('godmode_static_text_create'):l('godmode_static_text_edit');

	$f = new System\Form(array("default" => $dd, "id" => 'edit-text', "heading" => $heading));

	$f->input_text('name', l('godmode_name'), true);
	$f->input(array(
		"type" => 'textarea',
		"name"  => 'text',
		"label" => l('godmode_text'),
		"required" => true,
	));
	$f->input_checkbox('visible', l('godmode_visible'));

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

} else $this->error('params');
