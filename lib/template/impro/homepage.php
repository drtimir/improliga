<?

echo div(array('page-block', 'homepage'));

	echo div(array('block', 'left'));
		$renderer->slot('left');
	close('div');

	echo div(array('block', 'right'));
		$renderer->slot('right');
	close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
	echo div('block');
		$renderer->slot('events');
	close('div');

	echo span('cleaner', '');
close('div');
