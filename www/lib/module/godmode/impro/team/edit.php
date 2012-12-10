<?

def($new, false);
def($id);
def($redirect, '/god/impro/teams/{id_impro_team}/');
def($heading, $new ? l('godmode_impro_team_create'):l('godmode_impro_team_edit'));


if (($new && $item = new Impro\Team()) || ($id && $item = find("\Impro\Team", $id))) {

	$f = new System\Form(array("default" => $item->get_data(), "heading" => $heading));
	$f->input_text("name", l('godmode_team_name'), true);
	$f->input_text("name_full", l('godmode_team_name_full'), true);

	$f->input(array(
		"type"  => 'textarea',
		"name"  => 'about',
		"label" => l('godmode_team_about'),
		"required" => true,
	));

	$f->input_url("site", l('godmode_team_site'));
	$f->input_checkbox("visible", l('godmode_visible'));

	$f->submit(l('godmode_save'));

	if ($f->passed()) {

		$item->update_attrs($f->get_data())->save();
		message('success', $heading, l('godmode_save_success'), true);
		redirect(soprintf($redirect, $item));


	} else {
		$f->out($this);
	}

}

