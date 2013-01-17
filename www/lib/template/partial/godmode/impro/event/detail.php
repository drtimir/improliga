<?

echo heading($event->title);

Tag::ul();

	Tag::li(array(
		"content" => array(
			Tag::span(array("class" => "label", "content" => l('impro_event_type').':', "output" => false)),
			Tag::span(array("class" => "value", "content" => $event->get_type_name(), "output" => false)),
	)));

	Tag::li(array(
		"content" => array(
			Tag::span(array("class" => "label", "content" => l('impro_event_start').':', "output" => false)),
			Tag::span(array("class" => "value", "content" => format_date($event->start, 'human'), "output" => false)),
	)));

	if ($event->image->get_path()) {
		Tag::li(array(
			"content" => array(
				Tag::span(array("class" => "label", "content" => l('impro_event_image').':', "output" => false)),
				Tag::span(array("class" => "value", "content" => $event->image->get_path(), "output" => false)),
		)));
	}

	Tag::li(array(
		"content" => array(
			Tag::span(array("class" => "label", "content" => l('godmode_visible').':', "output" => false)),
			Tag::span(array("class" => "value", "content" => l($event->visible ? 'yes':'no'), "output" => false)),
	)));

	Tag::li(array(
		"content" => array(
			Tag::span(array("class" => "label", "content" => l('godmode_published').':', "output" => false)),
			Tag::span(array("class" => "value", "content" => l($event->published ? 'yes':'no'), "output" => false)),
	)));

Tag::close('ul');

Tag::div(array(
	"class" => 'desc short',
	"content" => $event->desc_short
));

Tag::div(array(
	"class" => 'desc',
	"content" => $event->desc_full
));
