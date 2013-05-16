<?

echo div('article');

	echo $renderer->heading($article->get_name());

	if (any($chapters)) {
		if (count($chapters) > 1) {
			Tag::ol(array("class" => 'chapters'));

				foreach ($chapters as $chapter) {
					echo li(array(
						$renderer->heading_static($chapter->get_name()),
						$chapter->text,
					), 'chapter');
				}
			close('ol');
		} else {
			$chapter = first($chapters);

			echo div('chapter', $chapter->text);
		}
	}


close('div');

