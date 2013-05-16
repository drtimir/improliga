<?

echo div('event_detail');
	echo div('left');

		echo $ren->heading($event->name);

		$date = '';
		if (is_null($event->end)) {
			$date = format_date($event->start, 'human-full-date');
		} else {
			$date = format_date($event->start, 'human-date') . ' - ' . format_date($event->end, 'human-date');
		}

		echo ul('info plain');
			echo li($date, 'icon date');

			if (is_null($event->end)) {
				echo li(t('impro_event_start_at', format_date($event->start, 'human-time')), 'icon time');
			}

			if ($event->location) {
				echo li(array($event->location->name, span('addr', $event->location->addr)), 'icon location');
			}

			if ($event->has_booking) {
				$total = $event->reservations->count();
				echo li('icon booking', $event->capacity.'/'.$total);
			}

			if ($event->price) {

				if ($event->price_student) {
					$content = t('impro_event_price_value_both', $event->price, $event->price_student);
				} else {
					$content = t('impro_event_price_value', $event->price);
				}

				echo li('icon price', $content);
			}
		close('ul');



		if ($event->desc_short) {
			echo div('text short', \System\Template::to_html($event->desc_short));
		}


		echo div('desc');

			if ($event->type === Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				echo div('participants', array(
					div('part home', $ren->link($request->url('public_team_detail', array($event->team_home)), $event->team_home->name)),
					span('vs', 'vs'),
					div('part away', $ren->link($request->url('public_team_detail', array($event->team_home)), $event->team_away->name)),
				));
			}

		close('div');


		echo div('text full', \System\Template::to_html($event->desc_full));

		if ($event->location) {
			echo $event->location->map_html(460, round($col_width/1.5));
		}

	close('div');

	echo div('right',
		$ren->link($event->image->get_path(), $event->image->to_html($col_width, $col_width), array("class" => 'image fancybox'))
	);

	echo span('cleaner', '');
close('div');
