<?


echo div('team_comments');

	if (any($comments)) {
		$has_right = $member && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE);
		$anonym_avatar = \System\Image::from_path('/share/pixmaps/impro/anonymous_user.png');
		echo ul('plain comments');

			foreach ($comments as $post) {
				$responses_html = '';

				if ($post->response_count) {
					$responses = array_reverse($post->get_responses()->paginate(3)->fetch());

					foreach ($responses as $response) {

						$menu = '';
						if ($post->id_author == $request->user->id || $has_right) {
							$menu = ul('plain menu-moderator', li(
								$ren->icon_for_url('team_comment_response_delete', 'impro/actions/delete', 16, args($team, $post, $response))
							));
						}

						$responses_html .= li(array(
							$response->to_html($ren),
							$menu,
						));
					}

					$responses_html = div('responses', array(
						ul('plain response_list', $responses_html),
						div('more', $ren->link_for('team_comment_respond', $locales->trans('impro_team_comment_respond'), args($team, $post))),
					));
				}

				$menu = '';
				if ($post->id_author == $request->user->id || $has_right) {
					$menu = ul('plain menu-moderator', li(
						$ren->icon_for_url('team_comment_delete', 'impro/actions/delete', 16, args($team, $post))
					));
				}

				Tag::li(array(
					"class" => 'post',
					"content" => array(
						$post->to_html($ren),
						$responses_html,
						$menu,
					)
				));

				close('li');
			}

		close('ul');
	} else {

		Tag::p(array("comment" => $locales->trans('impro_team_has_no_comments')));

	}
close('div');
