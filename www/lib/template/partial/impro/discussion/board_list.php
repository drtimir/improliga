<?

echo div('discussion');

	echo $ren->heading($heading);
	echo ul('actions plain', array(
		li(array("content" => $ren->icon_for_url('discussion_board_create', 'godmode/actions/create', 16, array("title" => l('impro_discussion_board_create'))))),
	));


echo ul(array('boards', 'plain'));

	foreach ($boards as $board) {
		echo li('board');
			$ren->heading($ren->link_for('discussion_board', $board->name, args($board)), false);
			echo div('topics');
				$latest = $board->latest();

				if (!$board->locked) {
					echo ul('actions plain', array(
						li($ren->icon_for_url('discussion_topic_create', 'godmode/actions/create', 16, array("args" => array($board), "title" => l('impro_discussion_topic_create')))),
					));
				}

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
								Tag::td(array("content" => $ren->link_for('discussion_topic', $topic->name, args($board, $topic))));
								Tag::td(array("content" => $topic->last_post_author ? Impro\User::link($ren, $topic->last_post_author):'-'));
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
