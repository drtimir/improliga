<?

Tag::menu(array("class" => 'menu-panel'));

	echo li($ren->icon_for('#', 'godmode/window/refresh', 24, array("title" => $locales->trans('godmode_window_refresh'))), array('button', 'refresh'));

	$count = count($options);
	$x = 0;

	foreach ($options as $opt) {
		$x ++;

		if (!is_null($opt) || $x < $count) {
			Tag::li(array(
				"class" => is_null($opt) ? 'separator':'',
				"content" => is_null($opt) ?
					span(null, ''):
					$ren->icon_for($opt['url'], 'godmode/'.$opt['icon'], 24, array("title" => $locales->trans($opt['title'], $model)))
			));
		}
	}

Tag::close('menu');
