<?

echo div('page-block');

	echo div(array('block', 'content'));
		$renderer->slot();
	close('div');

close('div');

