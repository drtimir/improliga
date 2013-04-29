<?

Tag::div(array("class" => 'event_detail'));

	Tag::div(array("class" => 'left'));

		echo section_heading($event->name);


		$date = '';
		if (is_null($event->end)) {
			$date = format_date($event->start, 'human-full-date');
		} else {
			$date = format_date($event->start, 'human-date') . ' - ' . format_date($event->end, 'human-date');
		}

		Tag::ul(array("class" => 'info plain'));
			Tag::li(array("class" => 'icon date', "content" => $date));

			if (is_null($event->end)) {
				Tag::li(array("class" => 'icon time', "content" => t('impro_event_start_at', format_date($event->start, 'human-time'))));
			}

			if ($event->location) {
				Tag::li(array("class" => 'icon location', "content" => $event->location->name.Tag::span(array("output" => false, "class" => 'addr', "content" => $event->location->addr))));
			}

			if ($event->has_booking) {
				$total = $event->reservations->count();
				Tag::li(array("class" => 'icon booking', "content" => $event->capacity.'/'.$total));
			}

			if ($event->price) {

				if ($event->price_student) {
					$content = t('impro_event_price_value_both', $event->price, $event->price_student);
				} else {
					$content = t('impro_event_price_value', $event->price);
				}

				Tag::li(array("class" => 'icon price', "content" => $content));
			}
		Tag::close('ul');



		if ($event->desc_short) {
			Tag::div(array("class" => 'text short', "content" => $event->desc_short));
		}


		Tag::div(array("class" => 'desc'));

			if ($event->type === Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				Tag::div(array("class" => 'participants'));
					Tag::div(array("class" => 'part home', "content" => array(
						link_for($event->team_home->name, soprintf($link_team, $event->team_home)),
					)));
					Tag::span(array("class" => 'vs', "content" => 'vs'));
					Tag::div(array("class" => 'part away', "content" => array(
						link_for($event->team_away->name, soprintf($link_team, $event->team_away)),
					)));
				Tag::close('div');
			}

		Tag::close('div');


		Tag::div(array("class" => 'text full', "content" => $event->desc_full));

		if ($event->location) {
			echo $event->location->map_html(460, round($col_width/1.5));
		}

	Tag::close('div');
	Tag::div(array("class" => 'right'));

		echo link_for($event->image->to_html($col_width, $col_width), $event->image->get_path(), array("class" => 'image fancybox'));

	Tag::close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
Tag::close('div');
