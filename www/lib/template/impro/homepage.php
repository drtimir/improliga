<?

Tag::div(array("class" => 'page-block'));

	Tag::div(array("class" => array('block', 'left')));
		slot('left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right')));
		slot('right');
	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
	Tag::div(array("class" => array('block', 'left')));
		slot('events_left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right')));
		slot('events_right');
	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
Tag::close('div');