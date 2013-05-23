<?

echo div('discussion post_list');

	echo $ren->heading($ren->link_for('discussion_topic', $topic->name, args($board, $topic)));
	echo $ren->heading($ren->link_for('discussion_board', $board->name, args($board)));

	echo div('desc', to_html($topic->desc));

	echo div('post_form');
		$ren->slot('discussion_post_form');
	close('div');


	echo ul('posts plain');

		foreach ($posts as $post) {
			echo li(array(
				div('avatar', Impro\User::avatar($ren, $post->author)),
				div('author', Impro\User::link($ren, $post->author)),
				div('text', to_html($post->text)),
				div('footer', array(
					$ren->link('#post_'.$post->id, format_date($post->created_at, 'human'), array("class" => 'date'))
				)),
			), 'post', 'post_'.$post->id);
		}

	close('ul');
close('div');
