<?

Tag::div(array("class" => 'discussion'));

echo section_heading($heading);

Tag::ul(array("class" => 'actions plain'));
	Tag::li(array("content" => icon_for('godmode/actions/create', 16, $link_board_create, l('impro_discussion_board_create'))));
Tag::close('ul');


Tag::ul(array("class" => array('boards', 'plain')));

	foreach ($boards as $board) {
		Tag::li(array("class" => 'board'));
			echo section_heading(link_for($board->name, soprintf($link_board, $board)), 2);
			Tag::div(array("class" => 'topics'));
				$latest = $board->latest();

				Tag::ul(array("class" => 'actions plain'));
					if (!$board->locked) {
						Tag::li(array("content" => icon_for('godmode/actions/create', 16, soprintf($link_topic_create, $board), l('impro_discussion_topic_create'))));
					}
				Tag::close('ul');

				if (any($latest)) {
					Tag::table(array("class" => 'topic_table'));
					Tag::thead();
						Tag::tr();
							Tag::th(array("class" => 'topic', "content" => l('impro_discussion_topic')));
							Tag::th(array("class" => 'last',  "content" => l('impro_discussion_last_author')));
							Tag::th(array("class" => 'date',  "content" => l('impro_discussion_updated_at')));
						Tag::close('tr');
					Tag::close('thead');

					Tag::tbody();

						foreach ($latest as $topic) {
							Tag::tr();
								Tag::td(array("content" => link_for($topic->name, soprintf($link_topic, $topic))));
								Tag::td(array("content" => $topic->last_post_author ? Impro\User::link($topic->last_post_author):'-'));
								Tag::td(array("content" => format_date($topic->updated_at, 'human')));

							Tag::close('tr');
						}

					Tag::close('tbody');
					Tag::close('table');
				} else Tag::p(array("class" => 'info', "content" => l('impro_discussion_no_topics')));

			Tag::close('div');
		Tag::close('li');
	}

Tag::close('ul');
Tag::close('div');
