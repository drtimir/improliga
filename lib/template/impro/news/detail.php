<?

echo div('news_detail');

	echo $ren->heading($item->name);

	if ($display_author) {
		$author = Stag::a(array(
			"class"   => 'author',
			"href"    => $ren->url('profile_user', array($item->author)),
			"content" => $item->author->get_name()
		));
	} else $author = '';

	echo div('news_text', $item->text);
	echo div('footer', array(
		Tag::datetime(array("output" => false, "content" => $locales->format_date($item->created_at, 'human-full-date'))),
		$author,
	));

echo close('div');
