<?

Tag::div(array("class" => 'discussion'));

echo section_heading($board->name);
echo heading($heading);
echo link_for(l('impro_discussion_create_topic'), soprintf($link_topic_create, $board));

Tag::ul(array("class" => 'topics'));

	foreach ($topics as $topic) {
		Tag::li(array("class" => 'plain'));

		echo link_for($topic->name, soprintf($link_topic, $topic));

		Tag::close('li');
	}

Tag::close('ul');
Tag::close('div');
