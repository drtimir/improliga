<?

echo div('carticle_list');

	echo $ren->heading($heading);

	foreach ($categories as $category) {
		$articles = $category->articles->where(array("visible" => true, "published" => true))->fetch();

		if (any($articles)) {
			echo div('category');
				echo $ren->heading_static($category->name);
				echo ul('article_list');

				foreach ($articles as $article) {
					$chapters = $article->chapters->where(array("visible" => true))->fetch();

					echo li();

						echo $ren->link_for('article', $article->name, args($article));

						if (count($chapters) > 2) {
							Tag::ol(array("class" => 'chapter_list'));
								foreach ($chapters as $chapter) {
									echo li($ren->link_for('article_chapter', $chapter->name, args($article, \System\Url::gen_seoname($chapter->name))));
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
