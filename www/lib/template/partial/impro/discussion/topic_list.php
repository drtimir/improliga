<?

Tag::div(array("class" => 'discussion topic_list'));

	echo $ren->heading($ren->link_for('discussion_board', $board->name, args($board)));
	echo $ren->heading($heading);

	echo div('desc', $board->desc);

	echo ul('actions plain', array(
		li($ren->icon_for_url('discussion_topic_create', 'godmode/actions/create', 16, array("args" => array($board), "title" => l('impro_discussion_topic_create')))),
	));

	echo div('topics');
		if (any($topics)) {
			Tag::table(array("class" => 'topic_table'));
			Tag::thead();
				Tag::tr();
					Tag::th(array("class" => 'topic', "content" => l('impro_discussion_topic')));
					Tag::th(array("class" => 'last', "content" => l('impro_discussion_last_author')));
					Tag::th(array("class" => 'date', "content" => l('impro_discussion_updated_at')));
				close('tr');
			close('thead');

			Tag::tbody();
				foreach ($topics as $topic) {
					Tag::tr();
						Tag::td(array("content" => $ren->link_for('discussion_topic', $topic->name, args($board, $topic))));
						Tag::td(array("content" => $topic->last_post_author ? Impro\User::link($ren, $topic->last_post_author):'-'));
						Tag::td(array("content" => format_date($topic->updated_at, 'human')));

					close('tr');
				}

			close('tbody');
			close('table');
		} else Tag::p(array("content" => l('impro_discussion_no_topics')));

	close('div');
close('div');
