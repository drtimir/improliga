<?

echo div(array('block', 'left'));
	$ren->slot('left');
close('div');

echo div(array('block', 'right'));
	$ren->slot('right');
close('div');

echo span('cleaner', '');
