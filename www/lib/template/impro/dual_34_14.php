<?

Tag::div(array("class" => 'page-block'));

	Tag::div(array("class" => array('block', 'left', 'layout_34')));
		$renderer->slot('left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right', 'layout_14')));
		$renderer->slot('right');
	Tag::close('div');

	echo span('cleaner', '');
Tag::close('div');
