<?

def($id);
def($id_board);
def($new, false);
def($heading, l($new ? 'impro_discussion_topic_create':'impro_discussion_topic_edit'));
def($redirect, '/discussion/{id_board}/{id_impro_discussion_topic}');


if (($id_board && ($board = find('\Impro\Discussion\Board', $id_board)) && (($id && $item = find('\Impro\Discussion\Topic', $id)) || ($new && $item = new Impro\Discussion\Topic())))) {

	$item->id_board = $id_board;

	if ($new) {
		$item->visible = true;
	}

	$f = new System\Form(array(
		"default" => $item->get_data(),
		"heading" => $heading,
		"action"  => intra_path(),
	));

	$f->input_text('name', l('impro_discussion_topic_name'), true);
	$f->input_textarea('desc', l('impro_discussion_topic_desc'), true);
	$f->input_checkbox('visible', l('godmode_visible'), false, l('impro_discussion_visible_hint'));
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
