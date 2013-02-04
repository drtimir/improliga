<?

Tag::div(array("class" => 'page-block'));

	require ROOT.'/lib/template/layout/intra/menu.php';

	Tag::div(array("class" => array('block', 'left_big')));
		slot('left');
	Tag::close('div');

	Tag::div(array("class" => array('block', 'right_small')));
		slot('right');
	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
Tag::close('div');
