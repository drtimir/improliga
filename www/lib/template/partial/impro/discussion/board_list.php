<?

Tag::div(array("class" => 'discussion'));

echo section_heading($heading);
echo link_for(l('impro_discussion_create_board'), '/discussion/create_board/');

Tag::ul(array("class" => array('boards', 'plain')));

	foreach ($boards as $board) {
		Tag::li();
			echo heading(link_for($board->name, soprintf($link_board, $board)));
			Tag::div(array("class" => 'topics'));
				$latest = $board->latest();
				if (any($latest)) {
					Tag::table(array("class" => 'topic_table'));
					Tag::thead();
						Tag::tr();
							Tag::th(array("content" => l('impro_discussion_topic')));
							Tag::th(array("content" => l('impro_discussion_last_author')));
							Tag::th(array("content" => l('impro_discussion_updated_at')));
						Tag::close('tr');
					Tag::close('thead');

					Tag::tbody();

						foreach ($latest as $topic) {
							Tag::tr();
								Tag::td(array("content" => link_for($topic->name, soprintf($link_topic, $topic))));
								Tag::td(array("content" => $topic->last_post_author ? $topic->last_post_author->get_name():'-'));
								Tag::td(array("content" => $topic->updated_at));

							Tag::close('tr');
						}

					Tag::close('tbody');
					Tag::close('table');
				} else Tag::p(array("content" => l('impro_discussion_no_topics')));

			Tag::close('div');
		Tag::close('li');
	}

Tag::close('ul');
Tag::close('div');
