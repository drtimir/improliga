<?

content_for("styles", 'calendar');

Tag::div(array("class" => 'calendar'));
	if ($heading) echo section_heading($heading, 1);

	Tag::div(array("class" => 'calendar-'.$mode));
		Tag::div(array("class" => 'calendar-'.$mode.'-inner'));
			switch($mode) {
				case 'month-grid':
				{
					def($dn, 0);

					Tag::ul(array("class" => 'calendar-head'));
						foreach (System\Locales::get($day_names_short ? 'date:days-short':'date:days') as $d) {
							Tag::li(array("class" => 'day', "content" => '<span>'.$d.'</span>'));
						}
					Tag::close('ul');

					$date = clone $start;
					$cells = 0;

					if ($first != 1) {
						if ($first) {
							$date->modify("-".(intval($first)-1)." day");
						} else {
							$date->modify("-6 day");
						}

					}

					$startstamp = $start->getTimestamp();
					$endstamp   = $end->getTimestamp();

					while ((($dstamp = $date->getTimestamp()) < $endstamp) || $cells % 7) {
						$dayclass = array('day');
						if ($cells == 0 || !($cells % 7)) {
							if ($cells != 0) Tag::close('div');

							Tag::div(array("class" => 'week'));
						}

						if ($dstamp < $startstamp || $dstamp >= $endstamp) {
							$dayclass[] = 'day-inactive';
							$noev = true;
						} else {
							$noev = false;
						}

						$dn = $date->format('j');

						if (!$noev && any($elist = &$events[$dn])) {
							$dayclass[] = 'day-events';
						} else {
							$elist = array();
						}

						$helper = new DateTime();
						$d1 = new DateTime($date->format('Y-m-d'));
						$d2 = $helper->format('Y-m-d');

						if ($d1->getTimestamp() === $d2->getTimestamp()) {
							$dayclass[] = 'today';
						}

						Tag::div(array("class" => $dayclass));
							$tag = $day_link_integrate && any($elist) ? 'a':'div';

							Tag::$tag(array(
								"href"  => stprintf($link_day, array("year" => $date->format('Y'), 'month' => $date->format('m'), "day" => intval($date->format('d')))),
								"class" => 'day-head',
								"title" => format_date($date, 'human-full-date'),
								"content" => Tag::span(array(
									"class" => 'date-info',
									"content" => $dn,
									"output"  => false,
								))
							));

							if (!$day_link_integrate) {
								Tag::ul(array("class" => 'days-events'));
									foreach ($elist as $event) {
										$eb = false;

										Tag::li(array("class" => 'event'.($eb ? ' book-active':'')));
											echo $l = link_for($event->name, soprintf($link_cont, $event));

											Tag::ul(array("class" => 'event-info'));
												Tag::li(array("content" => $l));
												Tag::li(array("content" => l('impro_event_start').': '.format_date($event->start, 'human')));
											Tag::close('ul');
										Tag::close('li');
									}
								Tag::close('ul');
							}
						Tag::close('div');

						$date->modify("+1 day");
						$cells ++;
					}

					break;
				}
			}

			Tag::close('div');
		Tag::close('div');
	Tag::close('div');
Tag::close('div');
