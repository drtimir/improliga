<?

Tag::div(array("class" => 'calendar-controls'));
	Tag::div(array("class" => 'l'));
		echo icon_for('godmode/navi/first', $icon_size, $link_prev_year);
		echo icon_for('godmode/navi/prev', $icon_size, $link_prev_month);
	Tag::close('div');

	Tag::div(array("class" => 'r'));
		echo icon_for('godmode/navi/next', $icon_size, $link_next_month);
		echo icon_for('godmode/navi/last', $icon_size, $link_next_year);
	Tag::close('div');

	Tag::div(array("class" => 'mid'));
		$f->out();
		Tag::div(array("class" => 'cleaner'));
	Tag::close('div');

Tag::close('div');
