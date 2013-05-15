<?

echo div("window-content-menu");
	$renderer->slot('menu');
close('div');

echo div("window-content-inner");
	$renderer->yield();
	$renderer->slot();
close('div');
