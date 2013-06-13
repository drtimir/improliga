<?

echo div('team_comment_responses');

	echo $this->heading($locales->trans('impro_team_comment_responses'));

	$responses_html = '';

	echo div('team_comments', div('post', $comment->to_html($ren)));
	echo div('responses');

		if (any($responses)) {
			echo ul('plain team_comments response_list');
				foreach ($responses as $response) {
					Tag::li(array(
						"content" => $response->to_html($ren),
						"id" => 'post_'.$response->id,
					));
				}
			close('ul');
		}

		echo div('response');
			$ren->slot('response_edit');
		close('div');
	close('div');
close('div');
