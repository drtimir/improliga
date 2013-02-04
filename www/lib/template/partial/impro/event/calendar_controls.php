<?

Tag::div(array("class" => 'calendar-controls'));
	if ($heading) {
		echo section_heading($heading, 1);
	}

	Tag::div(array("class" => 'l'));
		echo icon_for('godmode/navi/prev', $icon_size, $link_prev_month);
	Tag::close('div');

	Tag::div(array("class" => 'r'));
		echo icon_for('godmode/navi/next', $icon_size, $link_next_month);
	Tag::close('div');

	Tag::div(array("class" => 'mid'));
		$f->out();
		Tag::span(array("class" => 'cleaner', "close" => true));
	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));

Tag::close('div');
