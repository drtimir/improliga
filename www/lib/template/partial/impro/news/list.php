<?
echo div('news');
	echo $ren->heading($locales->trans('impro_news'));

	if (any($news)) {

		echo ul(array('items', 'plain'));

		foreach ($news as $item) {
			$content = array();
			$content[] = $ren->heading($ren->link_for('news_detail', $item->name, array("args" => array($item))), false);
			$content[] = div('text', to_html($ren, $item->text));

			if ($display_author) {
				$author = Stag::a(array(
					"class"   => 'author',
					"href"    => soprintf($link_author, $item),
					"content" => $item->author->get_name()
				));
			} else $author = '';

			$content[] = div('footer', array(
					Stag::datetime(array("content" => $locales->format_date($item->created_at, 'human-full-date'))),
					$author,
			));

			echo li($content);
		}

		close('ul');

	} else Tag::p(array("content" => $locales->trans('impro_no_news')));

close('div');
