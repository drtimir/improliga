<?

Tag::div(array("class" => 'events'));

	echo $ren->heading($heading);

	$content = array();
	$today = mktime(0,0,0,date('m'), date('d'), date('Y'));
	$html_events = array();

	if (any($events)) {
		foreach ($events as $event) {
			$html_event = array();

			$html_event[] = Tag::a(array(
				"class"   => 'image',
				"output"  => false,
				"href"    => $ren->url('event', array($event)),
				"content" => $event->image->to_html($thumb_width, $thumb_height),
			));

			$ts = array(
				span('date', $locales->format_date($event->start, 'human')),
				'<br>',
				$event->get_type_name(),
			);

			if ($event->location) {
				$ts[] = ', ';
				$ts[] = Tag::a(array("class" => 'location', "output" => false, "href" => $event->location->map_link(), "content" => $event->location->name));
			}

			$location = div('ts_location', $ts);
			$match = '';

			if ($event->type === \Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				$match = div('match_participants', array(
					$ren->link_for('team', $event->team_home->name, args($event->team_home)),
					div('versus', ' vs '),
					$ren->link_for('team', $event->team_away->name, args($event->team_away)),
				));
			}


			$html_event[] = div('desc', array(
				$ren->link_for('event', $event->name, array("args" => array($event), "class" => 'name')),
				$match,
				$location,
				$show_desc ? div('text', to_html($ren, $event->desc_short)):'',
			));

			$html_event[] = span('cleaner', '');
			$html_events[] = li(implode('', $html_event), 'event');
		}

		Tag::ul(array(
			"class"   => 'plain event_list latest',
			"content" => $html_events,
		));

		Tag::span(array("class" => 'cleaner', "close" => true));

	} else {
		Tag::p(array("class" => 'info', "content" => $locales->trans('impro_event_lists_empty')));
	}

close('div');

