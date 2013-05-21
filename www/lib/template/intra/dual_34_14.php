<?

echo div('page-block');

	require ROOT.'/lib/template/intra/menu.php';

	echo div(array('block', 'left', 'layout_34'));
		$ren->slot('left');
	close('div');

	echo div(array('block', 'right', 'layout_14'));
		$ren->slot('right');
	close('div');

	echo span('cleaner', '');
close('div');
