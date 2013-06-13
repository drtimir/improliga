<?

echo div('page-block');

	require ROOT.'/lib/template/intra/menu.php';

	echo div(array('block', 'left', 'layout_11', 'content'));
		$ren->slot();

	close('div');
	echo span('cleaner', '');

close('div');

