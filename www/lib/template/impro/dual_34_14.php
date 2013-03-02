<?

Tag::div(array("class" => 'page-block'));

	Tag::div(array("class" => array('block', 'left', 'layout_34')));
		slot('left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right', 'layout_14')));
		slot('right');
	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
Tag::close('div');
