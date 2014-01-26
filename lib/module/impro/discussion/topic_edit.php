<?

def($id);
def($id_board);
def($new, false);
def($heading, $locales->trans($new ? 'impro_discussion_topic_create':'impro_discussion_topic_edit'));


if (($id_board && ($board = find('\Impro\Discussion\Board', $id_board)) && (($id && $item = find('\Impro\Discussion\Topic', $id)) || ($new && $item = new Impro\Discussion\Topic())))) {
	if (!$board->locked) {

		if ($new) {
			$item->board = $board;
			$item->visible = true;
		}

		$f = $ren->form(array(
			"default" => $item->get_data(),
			"heading" => $heading,
		));

		$f->input_text('name', $locales->trans('impro_discussion_topic_name'), true);
		$f->input_rte('desc', $locales->trans('impro_discussion_topic_desc'), true);
		$f->input_checkbox('locked', $locales->trans('impro_discussion_locked'), false, $locales->trans('impro_discussion_locked_hint'));
		$f->submit($heading);

		if ($f->passed()) {
			$p = $f->get_data();
			$item->update_attrs($p)->save();
			$flow->redirect($ren->url('discussion_topic', array($board, $item)));

		} else {
			$f->out($this);
		}
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
