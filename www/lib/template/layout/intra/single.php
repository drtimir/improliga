<?

Tag::div(array("class" => 'page-block'));

	require ROOT.'/lib/template/layout/intra/menu.php';

	Tag::div(array("class" => array('block', 'content')));
		slot();

	Tag::close('div');
Tag::close('div');

