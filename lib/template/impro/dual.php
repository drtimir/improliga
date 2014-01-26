<?

Tag::div(array("class" => 'page-block'));

	Tag::div(array("class" => array('block', 'left')));
		$renderer->slot('left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right')));
		$renderer->slot('right');
	Tag::close('div');

	echo span('cleaner', '');
Tag::close('div');
