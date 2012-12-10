<?
Tag::menu(array("class" => 'menu-panel'));

	Tag::li(array(
		"class"   => array('button', 'refresh'),
		"content" => icon_for('godmode/window/refresh', 24, '#', l('godmode_window_refresh'), array("label" => true))
	));

	foreach ($options as $opt) {
		Tag::li(array(
			"class" => is_null($opt) ? 'separator':'',
			"content" => is_null($opt) ?
				Tag::span(array("output" => false, "close" => true)):
				icon_for('godmode/'.$opt[2], 24, $opt[1], l($opt[0]), array("label" => true))
		));
	}

Tag::close('menu');
