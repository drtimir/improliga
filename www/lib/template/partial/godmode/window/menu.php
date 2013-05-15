<?

Tag::menu(array("class" => 'menu-panel'));

	Tag::li(array(
		"class"   => array('button', 'refresh'),
		"content" => label_for('godmode/window/refresh', 24, '#', l('godmode_window_refresh'))
	));

	$count = count($options);
	$x = 0;

	foreach ($options as $opt) {
		$x ++;

		if (!is_null($opt) || $x < $count) {
			Tag::li(array(
				"class" => is_null($opt) ? 'separator':'',
				"content" => is_null($opt) ?
					Tag::span(array("output" => false, "close" => true)):
					label_for('godmode/'.$opt['icon'], 24, $opt['url'], t($opt['title'], $model))
			));
		}
	}

Tag::close('menu');
