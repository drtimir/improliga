<?

def($new, false);
def($id);
def($redirect, '/god/impro/event/{id_impro_event}/');
def($heading, $new ? l('impro_event_create'):l('impro_event_delete'));


if (($new && $item = new Impro\Event()) || ($id && $item = find("\Impro\Event", $id))) {

	$f = new System\Form(array("default" => $item->get_data(), "heading" => $heading));
	$f->input_text("name", l('godmode_event_name'), true);
	$f->input(array(
		"type"    => 'select',
		"name"    => 'id_impro_event_type',
		"options" => Impro\Event\Type::get_all(),
		"label"   => l('impro_event_type')
	));

	$f->input_datetime("start", l('impro_event_start'), true);
	$f->input(array(
		"type"     => 'number',
		"name"     => "duration",
		"label"    => l('impro_event_duration'),
		"required" => true,
		"step"     => 1,
		"min"      => 0,
	));

	$f->input_file('image', l('impro_event_image'), false);

	$f->input(array(
		"type"  => 'textarea',
		"name"  => 'desc_short',
		"label" => l('impro_event_desc_short'),
		"required" => true,
	));

	$f->input(array(
		"type" => 'textarea',
		"name" => 'desc_full',
		"label" => l('impro_event_desc_full'),
		"required" => true,
	));

	$f->input(array(
		"type"  => 'datetime',
		"name"  => "publish_at",
		"label" => l('impro_event_publish_at'),
		"info"  => l('impro_event_publish_at_desc'),
	));

	$f->input_checkbox("all_day", l('impro_event_all_day'));
	$f->input_checkbox("visible", l('godmode_visible'));
	$f->input_checkbox("published", l('godmode_published'));

	$f->submit(l($new ? 'impro_event_create':'impro_event_edit'));

	if ($f->passed()) {
		$p = $f->get_data();

		$item->update_attrs($p)->save();
		redirect(soprintf($redirect, $item));

	} else {
		$f->out($this);
	}
}

