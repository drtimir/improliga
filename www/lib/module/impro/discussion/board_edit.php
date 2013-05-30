<?

def($id);
def($new, false);
def($heading, $locales->trans($new ? 'impro_discussion_board_create':'impro_discussion_board_edit'));
def($redirect, '/discussion/{id_impro_discussion_board}');


if (($id && $item = find('\Impro\Discussion\Board', $id)) || ($new && $item = new Impro\Discussion\Board())) {

	if ($new) {
		$item->visible = true;
		$item->public = true;
	}

	$f = $ren->form(array(
		"default" => $item->get_data(),
		"heading" => $heading,
	));

	$f->input_text('name', $locales->trans('impro_discussion_board_name'), true);
	$f->input_rte('desc', $locales->trans('impro_discussion_board_desc'), true);
	$f->input_checkbox('visible', $locales->trans('godmode_visible'), false, $locales->trans('impro_discussion_visible_hint'));
	$f->input_checkbox('public', $locales->trans('impro_discussion_public'), false, $locales->trans('impro_discussion_public_hint'));
	$f->input_checkbox('locked', $locales->trans('impro_discussion_locked'), false, $locales->trans('impro_discussion_locked_hint'));
	$f->submit($heading);

	if ($f->passed()) {
		$p = $f->get_data();
		$item->update_attrs($p)->save();
		redirect(soprintf($redirect, $item));

	} else {
		$f->out($this);
	}
}
