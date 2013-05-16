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

						echo $ren->link($request->url('public_article', array($article)), $article->name);

						if (count($chapters) > 2) {
							Tag::ol(array("class" => 'chapter_list'));
								foreach ($chapters as $chapter) {
									echo li($ren->link($request->url('public_article_chapter', array($article, \System\Url::gen_seoname($chapter->name))), $chapter->name));
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
