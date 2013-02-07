<?

Tag::div(array("class" => 'discussion post_list'));

echo section_heading(link_for($topic->name, soprintf($link_topic, $topic)));
echo heading(link_for($board->name, soprintf($link_board, $topic)));

Tag::div(array(
	"class" => 'desc',
	"content" => $topic->desc,
));

Tag::div(array("class" => 'post_form'));
	slot('discussion_post_form');
Tag::close('div');


Tag::ul(array("class" => 'posts plain'));

	foreach ($posts as $post) {
		Tag::li(array("class" => 'post', "id" => 'post_'.$post->id));

			Tag::div(array(
				"class"   => 'avatar',
				"content" => Impro\User::avatar($post->author),
			));

			Tag::div(array(
				"class"   => 'author',
				"content" => Impro\User::link($post->author),
			));

			Tag::div(array(
				"class" => 'text',
				"content" => $post->text
			));

			Tag::div(array("class" => 'footer'));
				Tag::a(array(
					"class"   => 'date',
					"href"    => '#post_'.$post->id,
					"content" => format_date($post->created_at, 'human'),
				));
			Tag::close('div');
		Tag::close('li');
	}

Tag::close('ul');
Tag::close('div');
