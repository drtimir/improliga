<?

Tag::div(array("class" => 'discussion'));

echo section_heading($heading);
echo link_for(l('impro_discussion_create_board'), '/discussion/create_board/');

Tag::ul(array("class" => 'boards'));

	foreach ($boards as $board) {
		Tag::li(array("class" => 'plain'));

		echo heading(link_for($board->name, soprintf($link_board, $board)));

		$latest = $board->latest();
		v($latest);

		Tag::close('li');
	}

Tag::close('ul');
Tag::close('div');
