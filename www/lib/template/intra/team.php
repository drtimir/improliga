<?

echo div('page-block team-layout');

	require ROOT.'/lib/template/intra/menu.php';

	echo div(array('block', 'left', 'layout_11', 'content'));
		slot('head');
	close('div');

	echo div(array('block', 'left', 'layout_11', 'content'));
		slot('big');
	close('div');

	echo div(array('block', 'left', 'layout_58'));
		slot('left');
	close('div');

	echo div(array('block', 'right', 'layout_38'));
		slot('right');
	close('div');

	slot();
close('div');

