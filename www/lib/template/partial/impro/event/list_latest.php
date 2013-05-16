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
				"href"    => soprintf($link_cont, $event),
				"content" => $event->image->to_html($thumb_width, $thumb_height),
			));

			$ts = array(
				span('date', format_date($event->start, 'human')),
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
					$ren->link($request->url('public_team_detail', array($event->team_home->get_seoname())), $event->team_home->name),
					div('versus', ' vs '),
					$ren->link($request->url('public_team_detail', array($event->team_away->get_seoname())), $event->team_away->name),
				));
			}


			$html_event[] = div('desc', array(
				$ren->link($request->url('public_event_detail', array($event->get_seoname())), $event->name, array("class" => 'name')),
				$match,
				$location,
				$show_desc ? div('text', \System\Template::to_html($event->desc_short)):'',
			));

			$html_event[] = span('cleaner', '');
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

