<?


$months = System\Locales::get('date:months');
$ren->content_for('title', t('title_impro_global', t('impro_event_list_for_month', $months[$month].' '.$year)));

echo div('events');

	echo $ren->heading(sprintf(l('impro_event_list_for_month'), $months[$month]));

	$content = array();
	$today = mktime(0,0,0,date('m'), date('d'), date('Y'));

	echo div('controls', array(
		$ren->label_for_url('events_month', l('impro_prev_month'), 'godmode/navi/prev', 16, array("args" => array($prev->format('Y-m')))),
		$ren->label_for_left($ren->url('events_month', array($next->format('Y-m'))), l('impro_next_month'), 'godmode/navi/next', 16),
	));


	foreach ($events as $d=>$list) {
		if (any($list)) {
			$html = array();
			$html_events = array();

			foreach ($list as $event) {
				$html_event = array();

				$url = $ren->url('event', array($event));
				$html_event[] = $ren->link($url, $event->image->to_html(100, 100), array("class" => 'image'));

				$ts = array(
					Tag::span(array("class" => 'date', "output"  => false, "content" => format_date($event->start, 'human'))),
					'<br>',
					$event->get_type_name(),
				);

				if ($event->location) {
					$ts[] = ', ';
					$ts[] = $ren->link_ext($event->location->map_link(), $event->location->name, array("class" => 'location'));
				}

				$location = div('ts_location', $ts);
				$match = '';

				if ($event->type === \Impro\Event\Type::ID_MATCH && $event->team_home && $event->team_away) {
					$match = div('match_participants', array(
						$ren->link_for('team', $event->team_home->name, array("args" => array($event->team_home))),
						span('versus', ' vs '),
						$ren->link_for('team', $event->team_away->name, array("args" => array($event->team_away))),
					));
				}

				$html_event[] = div('desc', array(
					$ren->link($url, $event->name, array("class" => 'name')),
					$match,
					$location,
					div('text', \System\Template::to_html($event->desc_short)),
				));

				$html_event[] = span('cleaner', '');
				$html_events[] = li(implode('', $html_event), 'event');
			}

			$dutime = mktime(0,0,0, $month, $d, $year);

			if ($today == $dutime) {
				$day_heading = l('today');
			} else {
				$day_heading = format_date(mktime(0,0,0, $month, $d, $year), 'l j. F');
			}

			$html[] = Tag::a(array(
				"href"    => stprintf($link_day, array("year" => $year, "month" => str_pad($month, 2, '0', STR_PAD_LEFT), "day" => $d)),
				"id"      => stprintf($link_day_piece, array("day" => $d)),
				"class"   => 'day-head',
				"content" => $day_heading,
				"output"  => false,
			));

			$html[] = ul('plain', $html_events);
			$content[] = li($html, 'day');
		}
	}

	if (any($content)) {

		echo ul('event_list plain', $content);

	} else {
		Tag::p(array("class" => 'info', "content" => l('impro_event_lists_empty')));
	}

close('div');
