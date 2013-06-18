<?

def($id);
def($id_board);
def($new, false);
def($heading, $locales->trans($new ? 'impro_discussion_topic_create':'impro_discussion_topic_edit'));
def($model, get_model('Impro\Team\Discussion\Topic'));


if (any($propagated['team']) && $team = $propagated['team']) {
	if (($id && $item = find($model, $id)) || ($new && $item = new $model())) {

		$item->team = $team;

		if ($new) {
			$item->visible = true;
		}

		$f = $ren->form(array(
			"default" => $item->get_data(),
			"heading" => $heading,
		));

		$f->input_text('name', $locales->trans('impro_discussion_topic_name'), true);
		$f->input_rte('desc', $locales->trans('impro_discussion_topic_desc'), true);
		$f->input_checkbox('visible', $locales->trans('godmode_visible'), false, $locales->trans('impro_discussion_visible_hint'));
		$f->input_checkbox('locked', $locales->trans('impro_discussion_locked'), false, $locales->trans('impro_discussion_locked_hint'));
		$f->submit($heading);

		if ($f->passed()) {

			$p = $f->get_data();

			if ($new) {
				$item->author = $request->user();
				$item->last_post_author = $request->user();
			}

			$item->update_attrs($p)->save();
			$flow->redirect($ren->url('team_discussion_topic', array($team, $item)));

		} else {
			$f->out($this);
		}
	}
} else throw new \System\Error\NotFound();
