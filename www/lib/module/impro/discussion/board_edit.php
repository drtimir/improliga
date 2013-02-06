<?

def($id);
def($new, false);
def($heading, l($new ? 'impro_discussion_board_create':'impro_discussion_board_edit'));
def($redirect, '/discussion/{id_impro_discussion_board}');


if (($id && $item = find('\Impro\Discussion\Board', $id)) || ($new && $item = new Impro\Discussion\Board())) {

	$f = new System\Form(array(
		"default" => $item->get_data(),
		"heading" => $heading,
		"action"  => intra_path(),
	));

	$f->input_text('name', l('impro_discussion_board_name'), true);
	$f->input_textarea('desc', l('impro_discussion_board_name'), true);
	$f->input_checkbox('visible', l('godmode_visible'), false, l('impro_discussion_visible_hint'));
	$f->input_checkbox('public', l('impro_discussion_public'), false, l('impro_discussion_public_hint'));
	$f->input_checkbox('locked', l('impro_discussion_locked'), false, l('impro_discussion_locked_hint'));
	$f->submit($heading);

	if ($f->passed()) {
		$p = $f->get_data();
		$item->update_attrs($p)->save();
		redirect(soprintf($redirect, $item));

	} else {
		$f->out($this);
	}
}
