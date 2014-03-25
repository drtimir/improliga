<?

$ren->content_for('title', $event->name.' - Improliga');

echo div('event_detail');
	echo div('left');

		echo $ren->heading($event->name);

		if ($request->intranet) {
			echo ul('plain controls', array(
				li($ren->label_for_url('event_edit', $locales->trans('godmode_edit'), 'impro/actions/edit', 16, args($event))),
				li($ren->label_for_url('event_edit_step', $locales->trans('godmode_delete'), 'impro/actions/delete', 16, args($event, \Impro\Event::ID_WIZZARD_STEP_CANCEL))),
			));
		}


		echo div('desc');

			if ($event->type === Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				echo div('participants', array(
					div('part home', $ren->link_for('team', $event->team_home->name, array("args" => array($event->team_home)))),
					span('vs', 'vs'),
					div('part away', $ren->link_for('team', $event->team_away->name, array("args" => array($event->team_away)))),
				));
			}

		close('div');

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
				echo li(array(
					span('name', $event->location->name),
					span('addr', $event->location->addr),
					$event->location->site ? span('site', $ren->link_ext($event->location->site, $event->location->site)):'',
				), 'icon location');
			}

			if ($event->price) {

				if ($event->price_student) {
					$content = $locales->trans('impro_event_price_value_both', $event->price, $event->price_student);
				} else {
					$content = $locales->trans('impro_event_price_value', $event->price);
				}

				echo li($content, 'icon price');
			}


			if ($event->use_booking) {
				$total = $event->reservations->count();

				if (($free = $event->capacity - $total) < 0) {
					$free = 0;
				}

				if ($free > 0) {
					$action = $ren->link_for('event_booking', $locales->trans('impro_event_book'), array(
						"args"  => array($event),
						"class" => 'action',
					));


					$free_str = 'impro_event_free';

					if ($free < 4) $free_str = 'impro_event_free_four';
					if ($free == 1) $free_str = 'impro_event_free_one';

					$count = span('count', $locales->trans($free_str, $free));
				} else {
					$action = span('action', $locales->trans('impro_event_sold_out'));
					$count = '';
				}

				echo li(array($action, $count), 'icon booking');
			}

			if ($request->intranet) {
				echo li($locales->trans('impro_event_manager').': '.\Impro\User::link($ren, $event->author), 'icon owner');
			}
		close('ul');

		if ($event->desc_short) {
			echo div('text short', to_html($ren, $event->desc_short));
		}

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