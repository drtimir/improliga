<?

Tag::div(array("class" => 'event_detail'));

	Tag::div(array("class" => 'left'));

		echo section_heading($event->title);

		Tag::div(array("class" => 'desc', "content" => array(

		)));

		Tag::div(array("class" => 'text short', "content" => $event->desc_short));
		Tag::div(array("class" => 'text full', "content" => $event->desc_full));

	Tag::close('div');
	Tag::div(array("class" => 'right'));

		Tag::a(array(
			"class"   => 'image',
			"href"    => $event->image->get_path(),
			"content" => Tag::img(array(
				"output" => false,
				"src"    => $event->image->thumb(270, 270),
				"alt"    => $event->title,
			)),
		));

		echo $event->location->map_html(270, 270);

	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
Tag::close('div');
