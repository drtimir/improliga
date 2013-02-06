<?

Tag::div(array("class" => 'discussion'));

echo section_heading(link_for($topic->name, soprintf($link_topic, $topic)));
echo heading(link_for($board->name, soprintf($link_board, $topic)));
echo link_for(l('impro_discussion_create_post'), soprintf($link_post_create, $topic));

Tag::ul(array("class" => 'posts'));

	foreach ($posts as $post) {
		Tag::li(array("class" => 'plain'));

		echo $post->text;

		Tag::close('li');
	}

Tag::close('ul');
Tag::close('div');
