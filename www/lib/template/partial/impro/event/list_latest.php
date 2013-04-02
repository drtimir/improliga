<?

Tag::div(array("class" => 'events'));

	echo section_heading($heading);

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
					"src"    => $event->image->thumb($thumb_width, $thumb_height),
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

			$location = div('ts_location', $ts);
			$match = '';

			if ($event->type === \Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
				$match = div('match_participants', array(
					link_for($event->team_home->name, soprintf($link_team, $event->team_home)),
					div('versus', ' vs '),
					link_for($event->team_away->name, soprintf($link_team, $event->team_away)),
				));
			}


			$html_event[] = div('desc', array(
				Tag::a(array(
					"class"   => 'name',
					"output"  => false,
					"content" => $event->name,
					"href"    => soprintf($link_cont, $event),
				)),
				$match,
				$location,
				$show_desc ? div('text', $event->desc_short):'',
			));

			$html_event[] = Tag::span(array("class" => 'cleaner', "output" => false, "close" => true));
			$html_events[] = Tag::li(array("class" => 'event', "content" => implode('', $html_event), "output" => false));
		}

		Tag::ul(array(
			"class"   => 'plain event_list latest',
			"content" => $html_events,
		));

		Tag::span(array("class" => 'cleaner', "close" => true));

	} else {
		Tag::p(array("class" => 'info', "content" => l('impro_event_lists_empty')));
	}

close('div');

