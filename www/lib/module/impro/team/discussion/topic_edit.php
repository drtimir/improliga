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

			if ($new) {
				$members = $team->members->fetch();

				foreach ($members as $member) {
					if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DISCUSSION)) {
						$notice = \Impro\User\Notice::for_user($member->user, array(
							"text"         => stprintf($ren->trans('internal_new_topic_notice'), array(
								"link_user"  => \Impro\User::link($ren, $request->user()),
								"link_team"  => $ren->link_for('team', $team->name, args($team)),
								"topic"      => $item->name,
							)),
							"redirect"     => $ren->uri('team_discussion_topic', array($team, $item)),
							"generated_by" => 'discussions',
							"id_author"    => $request->user()->id,
						));

						$notice->mail($locales);
					}
				}
			}

			$flow->redirect($ren->url('team_discussion_topic', array($team, $item)));
		} else {
			$f->out($this);
		}
	}
} else throw new \System\Error\NotFound();
