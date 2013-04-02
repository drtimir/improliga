<?

echo div(array('page-block', 'homepage'));

	echo div(array('block', 'left'));
		slot('left');
	close('div');

	echo div(array('block', 'right'));
		slot('right');
	close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
	echo div('block');
		slot('events');
	close('div');


	Tag::span(array("class" => 'cleaner', "close" => true));
close('div');
