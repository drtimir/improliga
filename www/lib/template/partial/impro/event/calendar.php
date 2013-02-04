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
						foreach (System\Locales::get('date:days') as $d) {
							Tag::li(array(
								"class"   => 'day',
								"content" => '<span>'.$d.'</span>',
							));
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

						Tag::div(array("class" => $dayclass));
							Tag::div(array("class" => 'day-head', "title" => format_date($date, 'human-full-date')));
								Tag::span(array("class" => 'date-info', "content" => $dn));
							Tag::close('div');
							Tag::ul(array("class" => 'days-events'));
								foreach ($elist as $event) {
									$eb = false;
									//$event->is_booked_by_user();

									Tag::li(array("class" => 'event'.($eb ? ' book-active':'')));
										echo $l = link_for($event->title, soprintf($cont_link, $event));

										Tag::ul(array("class" => 'event-info'));
											Tag::li(array("content" => $l));
											Tag::li(array("content" => l('impro_event_start').': '.format_date($event->start, 'human')));

											if ($booking) { ?>
												<li><a href="<?=soprintf($book_link, $event)?>"><?=$eb ? _('Změnit rezervaci'):_('Rezervace')?></a></li>
											<? }
										Tag::close('ul');
									Tag::close('li');
								}
							Tag::close('ul');
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
