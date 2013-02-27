<?

Tag::menu(array("class" => 'menu-panel'));

	Tag::li(array(
		"class"   => array('button', 'refresh'),
		"content" => label_for('godmode/window/refresh', 24, '#', l('godmode_window_refresh'))
	));


	foreach ($options as $opt) {
		Tag::li(array(
			"class" => is_null($opt) ? 'separator':'',
			"content" => is_null($opt) ?
				Tag::span(array("output" => false, "close" => true)):
				label_for('godmode/'.$opt[2], 24, $opt[1], l($opt[0]))
		));
	}

Tag::close('menu');
