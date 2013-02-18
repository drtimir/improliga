<?

Tag::div(array("class" => 'events'));

	echo section_heading(l('impro_events_latest'));

	$content = array();
	$today = mktime(0,0,0,date('m'), date('d'), date('Y'));
	$html_events = array();

	if (any($events)) {
		foreach ($events as $event) {
			$html_event = array();

			$html_event[] = Tag::a(array(
				"class"   => 'image',
				"output"  => false,
				"href"    => soprintf($link_cont, $event),
				"content" => Tag::img(array(
					"output" => false,
					"src"    => $event->image->thumb(100, 100),
					"alt"    => $event->name,
				)),
			));

			$ts = array(
				Tag::span(array("class" => 'date', "output"  => false, "content" => format_date($event->start, 'human'))),
				'<br>',
				$event->get_type_name(),
			);

			if ($event->location) {
				$ts[] = ', ';
				$ts[] = Tag::a(array("class" => 'location', "output" => false, "href" => $event->location->map_link(), "content" => $event->location->name));
			}

			$location = Tag::div(array(
				"class" => 'ts_location',
				"output"  => false,
				"content" => $ts,
			));

			$match = '';

			if ($event->id_impro_event_type === \Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				$match = Tag::div(array(
					"class"   => 'match_participants',
					"output"  => false,
					"content" => array(
						Tag::a(array(
							"href"    => soprintf($link_team, $event->team_home),
							"content" => $event->team_home->name,
							"output"  => false,
						)),
						Tag::span(array("output" => false, "content" => ' vs ', 'class' => 'versus')),
						Tag::a(array(
							"href"    => soprintf($link_team, $event->team_away),
							"content" => $event->team_away->name,
							"output"  => false,
						)),
					),
				));
			}

			$html_event[] = Tag::div(array(
				"class"   => 'desc',
				"output"  => false,
				"content" => array(
					Tag::a(array(
						"class"   => 'name',
						"content" => $event->name,
						"href"    => soprintf($link_cont, $event),
						"output"  => false,
					)),
					$match,
					$location,
					Tag::div(array(
						"class"   => 'text',
						"content" => $event->desc_short,
						"output"  => false,
					)),
				)
			));

			$html_event[] = Tag::span(array("class" => 'cleaner', "output" => false, "close" => true));
			$html_events[] = Tag::li(array("class" => 'event', "content" => implode('', $html_event), "output" => false));
		}

		Tag::ul(array(
			"class"   => 'plain event_list latest',
			"content" => $html_events,
		));

	} else {
		Tag::p(array("class" => 'info', "content" => l('impro_event_lists_empty')));
	}

Tag::close('div');
