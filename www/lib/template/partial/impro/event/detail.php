<?

$ren->content_for('title', $event->name.' - Improliga');

echo div('event_detail');
	echo div('left');

		echo $ren->heading($event->name);

		$date = '';
		if (is_null($event->end)) {
			$date = $locales->format_date($event->start, 'human-full-date');
		} else {
			$date = $locales->format_date($event->start, 'human-date') . ' - ' . $locales->format_date($event->end, 'human-date');
		}

		echo ul('info plain');
			echo li($date, 'icon date');

			if (is_null($event->end)) {
				echo li($locales->trans('impro_event_start_at', $locales->format_date($event->start, 'human-time')), 'icon time');
			}

			if ($event->location) {
				echo li(array($event->location->name, span('addr', $event->location->addr)), 'icon location');
			}

			if ($event->price) {

				if ($event->price_student) {
					$content = $locales->trans('impro_event_price_value_both', $event->price, $event->price_student);
				} else {
					$content = $locales->trans('impro_event_price_value', $event->price);
				}

				echo li($content, 'icon price');
			}


			if ($event->has_booking) {
				$total = $event->reservations->count();
				echo li($event->capacity.'/'.$total, 'icon booking');
			}
		close('ul');



		if ($event->desc_short) {
			echo div('text short', to_html($ren, $event->desc_short));
		}


		echo div('desc');

			if ($event->type === Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				echo div('participants', array(
					div('part home', $ren->link_for('team', $event->team_home->name, array("args" => array($event->team_home)))),
					span('vs', 'vs'),
					div('part away', $ren->link_for('team', $event->team_away->name, array("args" => array($event->team_home)))),
				));
			}

		close('div');


		echo div('text full', to_html($ren, $event->desc_full));

	close('div');

	echo div('right');
		echo $ren->link($event->image->get_path(), $event->image->to_html($ren, $col_width), array("class" => 'image fancybox'));

		if ($event->location) {
			echo $event->location->map_html($ren, $col_width);
		}
	close('div');


	echo span('cleaner', '');
close('div');
