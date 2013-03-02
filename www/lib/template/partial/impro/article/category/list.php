<?

Tag::div(array("class" => 'carticle_list'));

	echo section_heading($heading);

	foreach ($categories as $category) {
		$articles = $category->articles->where(array("visible" => true, "published" => true))->fetch();

		if (any($articles)) {
			Tag::div(array("class" => 'category'));
				echo heading($category->name, true, 3);
				Tag::ul(array("class" => 'article_list'));

				foreach ($articles as $article) {
					$chapters = $article->chapters->where(array("visible" => true))->fetch();

					Tag::li();

						echo link_for($article->get_name(), soprintf($link_article, $article));

						if (count($chapters) > 2) {
							Tag::ol(array("class" => 'chapter_list'));
								foreach ($chapters as $chapter) {
									Tag::li(array(
										"content" => link_for($chapter->name, soprintf($link_article, $article)),
									));
								}
							Tag::close('ol');
						}

					Tag::close('li');
				}

				Tag::close('ul');
			Tag::close('div');
		}
	}

Tag::close('div');
