<?


echo div('team_comments');

	if (any($comments)) {
		$anonym_avatar = \System\Image::from_path('/share/pixmaps/impro/anonymous_user.png');
		echo ul('plain comments');

			foreach ($comments as $post) {
				$responses_html = '';

				if ($post->response_count) {
					$responses = array_reverse($post->get_responses()->paginate(3)->fetch());

					foreach ($responses as $response) {
						$responses_html .= Stag::li(array(
							"content" => $response->to_html($link_response),
						));
					}

					$responses_html = div('responses', array(
						ul('plain response_list', $responses_html),
						div('more', link_for(l('impro_team_comment_respond'), soprintf($link_respond, $post))),
					));
				}


				Tag::li(array(
					"class" => 'post',
					"content" => array(
						$post->to_html($link_respond),
						$responses_html,
					)
				));

				close('li');
			}

		close('ul');
	} else {

		Tag::p(array("comment" => l('impro_team_has_no_comments')));

	}
close('div');
