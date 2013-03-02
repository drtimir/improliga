<?

Tag::div(array("class" => 'article'));

	echo section_heading($article->get_name());

	if (any($chapters)) {
		if (count($chapters) > 1) {
			Tag::ol(array("class" => 'chapters'));

				foreach ($chapters as $chapter) {
					Tag::li(array(
						"class"   => 'chapter',
						"content" => array(
							heading($chapter->get_name(), true, 2),
							$chapter->text,
						)
					));
				}
			Tag::close('ol');
		} else {
			$chapter = first($chapters);

			Tag::div(array(
				"class"   => 'chapter',
				"content" => $chapter->text,
			));
		}
	}


Tag::close('div');

