<?

Tag::div(array("class" => 'page-block'));

	require ROOT.'/lib/template/intra/menu.php';

	Tag::div(array("class" => array('block', 'left', 'layout_78')));
		slot('left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right', 'layout_18')));
		slot('right');
	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
Tag::close('div');
