<?

echo div('team-layout');
	echo div(array('block', 'left', 'layout_11', 'content'));
		$ren->slot('head');
	close('div');

	echo div(array('block', 'left', 'layout_11', 'content'));
		$ren->slot('big');
	close('div');

	echo div(array('block', 'left', 'layout_58'));
		$ren->slot('left');
	close('div');

	echo div(array('block', 'right', 'layout_38'));
		$ren->slot('right');
	close('div');

	$ren->slot();
	$ren->yield();

close('div');
