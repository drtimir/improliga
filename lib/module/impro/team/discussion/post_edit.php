<?

def($id);
def($id_topic);
def($new, false);
def($heading, $ren->trans($new ? 'impro_discussion_post_create':'impro_discussion_post_edit'));

$model = get_model('Impro\Team\Discussion\Post');
$throw_up = !(
		(
			(any($propagated['topic']) && $topic = $propagated['topic']) ||
			($id_topic && $topic = find('\Impro\Team\Discussion\Topic', $id_topic))
		) &&
		(any($propagated['team']) && $team = $propagated['team']) &&
		(($id && $item = find($model, $id)) || ($new && $item = new $model()))
	);

if (!$throw_up) {
	if ($new || $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE)) {
		$item->team  = $team;
		$item->topic = $topic;
		$item->visible  = true;

		$f = $ren->form(array(
			"default" => $item->get_data(),
			"heading" => $heading,
		));

		$f->input_rte('text', $ren->trans('impro_discussion_post_text'), true);
		$f->submit($heading);
		$f->out($this);

		if ($f->passed()) {
			$p = $f->get_data();

			if ($new) {
				$item->author = $request->user();
			}

			$item->update_attrs($p)->save();

			if ($new) {
				$users = $topic->posts
					->group_by('`t0`.`id_author`')
					->join('system_user', 'ON(`t0`.`id_author` = `users`.`id_system_user`)', 'users')
					->assoc_with('\System\User')
					->add_cols(\System\Model\Database::get_model_attr_list('\System\User'), 'users')
					->where(array('`t0`.`id_author` != '.$item->author->id))
					->fetch();

				foreach ($users as $user) {
					$notice = \Impro\User\Notice::for_user($user, array(
						"text"         => stprintf($ren->trans('internal_new_post_notice'), array(
							"link_user" => \Impro\User::link($ren, $item->author),
							"link_team" => $ren->link_for('team', $team->name, args($team)),
							"topic"     => $topic->name,
						)),
						"redirect"     => $ren->uri('team_discussion_topic', array($team, $topic)),
						"generated_by" => 'discussions',
						"id_author"    => $item->author->id,
					));
				}
			}

			$flow->redirect($ren->url('team_discussion_topic', array($team, $topic)));
		}
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();


