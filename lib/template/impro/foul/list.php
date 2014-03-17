<?

echo div('foul-list');

	echo section_heading('Seznam faulů');

	Tag::ul(array("class" => 'plain'));

	foreach ($items as $item) {
		Tag::li(array(
			"content" => link_for($item->name, soprintf($link_foul, $item))
		));
	}

	close('ul');
close('div');
