<?

Tag::div(array("class" => 'page-block'));

	Tag::div(array("class" => array('block', 'content')));
		slot();
	Tag::close('div');

Tag::close('div');

