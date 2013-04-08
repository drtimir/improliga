<?


echo div('team_comments');

	if (any($comments)) {
		$anonym_avatar = \System\Image::from_path('/share/pixmaps/impro/anonymous_user.png');
		echo ul('plain comments');

			foreach ($comments as $post) {
				$responses_html = '';

				if ($post->responses_count) {
					$responses_html .= ul('responses');

					foreach ($post->responses as $response) {
						$responses_html .= Stag::li(array(
							"content" => $response->to_html(),
						));
					}

					$responses_html .= \Stag::close('ul');
				}


				Tag::li(array(
					"class" => 'post',
					"content" => array(
						$post->to_html(),
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
