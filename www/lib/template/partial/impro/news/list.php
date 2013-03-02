<?
Tag::div(array("class" => 'news'));
	echo section_heading(l('impro_news'), 1, true);

	if (any($news)) {

		Tag::ul(array("class" => array('items', 'plain')));

		foreach ($news as $item) {
			$content = array();
			$content[] = section_heading(link_for($item->name, soprintf($link_cont, $item)));
			$content[] = Tag::div(array(
				"class"   => 'text',
				"content" => $item->text,
				"output"  => false,
			));

			if ($display_author) {
				$author = Stag::a(array(
					"class"   => 'author',
					"href"    => soprintf($link_author, $item),
					"content" => $item->author->get_name()
				));
			} else $author = '';

			$content[] = Tag::div(array(
				"class"   => 'footer',
				"output"  => false,
				"content" => array(
					Tag::datetime(array("output" => false, "content" => format_date($item->created_at, 'human-full-date'))),
					$author,
				)
			));

			Tag::li(array("content" => $content));
		}

		Tag::close('ul');

	} else Tag::p(array("content" => l('impro_no_news')));

Tag::close('div');
