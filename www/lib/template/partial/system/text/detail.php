<?

Tag::div(array("class" => 'system_text'));

	if ($show_heading) {
		echo section_heading($text->name);
	}

	Tag::div(array("class" => 'text', "content" => \System\Template::to_html($text->text)));

Tag::close('div');
