<?

echo div('carticle_list');

	echo $renderer->heading($heading);

	foreach ($categories as $category) {
		$articles = $category->articles->where(array("visible" => true, "published" => true))->fetch();

		if (any($articles)) {
			echo div('category');
				echo $renderer->heading_static($category->name);
				echo ul('article_list');

				foreach ($articles as $article) {
					$chapters = $article->chapters->where(array("visible" => true))->fetch();

					echo li();

						echo link_for($article->get_name(), soprintf($link_article, $article));

						if (count($chapters) > 2) {
							Tag::ol(array("class" => 'chapter_list'));
								foreach ($chapters as $chapter) {
									echo li(link_for($chapter->name, soprintf($link_article, $article)));
								}
							close('ol');
						}

					close('li');
				}

				close('ul');
			close('div');
		}
	}

close('div');
