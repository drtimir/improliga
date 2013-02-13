<?

Tag::div(array("class" => 'page-block'));

	require ROOT.'/lib/template/intra/menu.php';

	Tag::div(array("class" => array('block', 'left', 'layout_11', 'content')));
		slot();

	Tag::close('div');
Tag::close('div');

