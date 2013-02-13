<?

Tag::div(array("class" => 'events'));

	$months = System\Locales::get('date:months');
	echo section_heading(sprintf(l('impro_event_list_for_month'), $months[$month]));

	$content = array();

	foreach ($events as $day=>$list) {
		if (any($list)) {
			$html = array();
			$html_events = array();

			foreach ($list as $event) {
				$html_event = array();


				$html_event[] = Tag::a(array(
					"class"   => 'image',
					"output"  => false,
					"href"    => soprintf($cont_link, $event),
					"content" => Tag::img(array(
						"output" => false,
						"src"    => $event->image->thumb(100, 100),
						"alt"    => $event->title,
					)),
				));

				$location = Tag::div(array(
					"class" => 'ts_location',
					"output"  => false,
					"content" => array(
						Tag::a(array("class" => 'location', "output" => false, "href" => $event->location->map_link(), "content" => $event->location->name)),
						',',
						Tag::span(array("class" => 'date', "output"  => false, "content" => format_date($event->start, 'human-time'))),
					)
				));

				$match = '';

				if ($event->id_impro_event_type === \Impro\Event\Type::ID_MATCH) {
					$match = Tag::div(array(
						"class"   => 'match_participants',
						"output"  => false,
						"content" => array(
							Tag::a(array(
								"href"    => soprintf($link_team, $event->team_home),
								"content" => $event->team_home->name,
								"output"  => false,
							)),
							Tag::span(array("output" => false, "content" => 'vs', 'class' => 'versus')),
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
							"content" => $event->title,
							"href"    => soprintf($cont_link, $event),
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

				$html_events[] = Tag::li(array("class" => 'event', "content" => implode('', $html_event), "output" => false));
			}

			$html[] = Tag::a(array(
				"href"    => '#day_'.$day,
				"id"      => 'day_'.$day,
				"class"   => 'day-head',
				"content" => $day,
				"output"  => false,
			));

			$html[] = Tag::ul(array(
				"class"   => 'plain',
				"content" => $html_events,
				"output"  => false,
			));

			$content[] = Tag::li(array("output" => false, "class" => 'day', "content" => $html));
		}
	}

	if (any($content)) {

		Tag::ul(array(
			"class"   => 'event_list plain',
			"content" => $content,
		));

	} else {
		Tag::p(array("class" => 'info', "content" => l('impro_event_lists_empty')));
	}

Tag::close('div');
