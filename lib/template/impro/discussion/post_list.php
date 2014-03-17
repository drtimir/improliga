<?

echo div('discussion post_list');

	echo $ren->heading($ren->link_for('discussion_topic', $topic->name, args($board, $topic)));
	echo $ren->heading($ren->link_for('discussion_board', $board->name, args($board)));

	echo div('desc', to_html($ren, $topic->desc));

	echo div('post_form');
		$ren->slot('discussion_post_form');
	close('div');


	echo ul('posts plain');

		foreach ($posts as $post) {
			echo li(array(
				div('avatar', Impro\User::avatar($ren, $post->author)),
				div('author', array(
					Impro\User::link($ren, $post->author),
					$ren->link('#post_'.$post->id, $locales->format_date($post->created_at, 'human'), array("class" => 'link-date'))
				)),
				div('text', $post->text ? to_html($ren, $post->text):'<p class="gray">Prázdný příspěvek</p>'),
			), 'post', 'post_'.$post->id);
		}

	close('ul');
close('div');
