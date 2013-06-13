<?

Tag::div(array("class" => 'events'));

	echo div('controls', $ren->label_for($response->url('event_create'), $locales->trans('impro_event_create_new'), 'godmode/actions/create', 16));

	$content = array();
	$today = mktime(0,0,0,date('m'), date('d'), date('Y'));
	$html_events = array();

	if (any($events)) {

		Tag::table(array("class" => 'event_table', "cellspacing" => 0, "cellpadding" => 0));
			Tag::thead();
				Tag::tr(array("content" => array(
					\Stag::th(array("class" => 'img')),
					\Stag::th(array("content" => $locales->trans('impro_event_name'))),
					\Stag::th(array("content" => $locales->trans('impro_event_type'))),
					\Stag::th(array("content" => $locales->trans('impro_event_start'))),
					\Stag::th(array("content" => $locales->trans('intra_visible'))),
					\Stag::th(array("content" => $locales->trans('intra_published'))),
					\Stag::th(array("class" => 'actions')),
				)));
			close('thead');

			Tag::tbody();
				foreach ($events as $event) {
					Tag::tr();

						$loc = '';
						if ($event->location) {
							$loc = span('loc', $event->location->name);
						}

						Tag::td(array(
							"content" => $ren->link_for('event', $event->image->to_html($ren, 48, 48), array("args" => array($event), "class" => 'image'))
						));

						Tag::td(array(
							"content" => array(
								$ren->link_for('event', $event->name, array("args" => array($event), "class" => 'name')),
								$loc,
							)
						));

						Tag::td(array(
							"content" => $locales->trans($event->get_type_name()),
						));

						Tag::td(array(
							"content" => $locales->format_date($event->start, 'human')
						));

						Tag::td(array("content" => to_html($ren, $event->visible)));
						Tag::td(array("content" => to_html($ren, $event->published)));
						Tag::td(array(
							"class" => 'actions',
							"content" => array(
								$ren->icon_for_url('event_edit_step', 'godmode/actions/edit', 16, args($event, \Impro\Event::ID_WIZZARD_STEP_NAME)),
								$ren->icon_for_url('event_edit_step', 'godmode/actions/drop', 16, args($event, \Impro\Event::ID_WIZZARD_STEP_CANCEL)),
							)
						));
				}

			close('tbody');
		close('table');

		Tag::span(array("class" => 'cleaner', "close" => true));

	} else {
		Tag::p(array("class" => 'info', "content" => $locales->trans('impro_event_lists_empty')));
	}

close('div');

