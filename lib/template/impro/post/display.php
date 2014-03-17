<?

div('post');
	if ($post->type == \Impro\Post::MESSAGE) {
		$ren->render_partial('impro/post/message', array("post" => $post));
	} elseif ($post->type == \Impro\Post::SURVEY) {
		$ren->render_partial('impro/post/survey', array("post" => $post));
	} elseif ($post->type == \Impro\Post::FILE) {
		$ren->render_partial('impro/post/file', array("post" => $post));
	} elseif ($post->type == \Impro\Post::IMAGE) {
		$ren->render_partial('impro/post/image', array("post" => $post));
	} else {
		throw new \System\Error\Template('Unknown post type');
	}
close('div');
