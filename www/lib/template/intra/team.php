<?

echo div('page-block');

	require ROOT.'/lib/template/intra/menu.php';

	echo div(array('block', 'left', 'layout_11', 'content'));
		slot('head');
	close('div');

	echo div(array('block', 'left', 'layout_34'));
		slot('left');
	close('div');

	echo div(array('block', 'right', 'layout_14'));
		slot('right');
	close('div');

	slot();
close('div');

