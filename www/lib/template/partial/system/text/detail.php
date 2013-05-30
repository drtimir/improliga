<?

echo div('system_text');

	if ($show_heading) {
		echo $renderer->heading($text->name);
	}

	echo div('text', to_html($ren, $text->text));

close('div');
