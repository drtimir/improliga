<?

echo div('page-block');

	require ROOT.'/lib/template/intra/menu.php';

	echo div(array('block', 'left'));
		$ren->slot('left');
	close('div');

	echo div(array('block', 'right'));
		$ren->slot('right');
	close('div');

	echo span('cleaner', '');
close('div');
