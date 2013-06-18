<?

Tag::div(array("class" => 'discussion topic_list'));

	echo $ren->heading($ren->link_for('discussion_board', $board->name, args($board)));
	echo $ren->heading($heading);

	echo div('desc', $board->desc);

	$menu = array();

	if (!$board->locked) {
		$menu[] = li($ren->label_for_url('discussion_topic_create', $locales->trans('impro_discussion_topic_create'), 'godmode/actions/create', 16, args($board)));
	}

	if ($board->is_managable($request->user)) {
		$menu[] = li($ren->label_for_url('discussion_board_edit', $locales->trans('godmode_edit'), 'impro/actions/edit', 16, args($board)));
		$menu[] = li($ren->label_for_url('discussion_board_delete', $locales->trans('godmode_delete'), 'impro/actions/delete', 16, args($board)));
	}

	if (any($menu)) {
		echo ul('controls plain', $menu);
	}

	echo div('topics');
		if (any($topics)) {
			echo table('topic_table');
			echo thead(null, tr(null, array(
					th('topic', $locales->trans('impro_discussion_topic')),
					th('last', $locales->trans('impro_discussion_last_author')),
					th('date', $locales->trans('impro_discussion_updated_at')),
					th('editor', ''),
				))
			);

			echo tbody();
				$x = 0;

				foreach ($topics as $topic) {

					$menu = array();

					if ($topic->is_managable($request->user)) {
						$menu[] = $ren->icon_for_url('discussion_topic_edit', 'impro/actions/edit', 16, args($board, $topic));
						$menu[] = $ren->icon_for_url('discussion_topic_delete', 'impro/actions/delete', 16, args($board, $topic));
					}

					echo tr($x++%2 ? 'odd':'even', array(
						td(null, $ren->link_for('discussion_topic', $topic->name, args($board, $topic))),
						td(null, $topic->last_post_author ? Impro\User::link($ren, $topic->last_post_author):'-'),
						td(null, $locales->format_date($topic->updated_at, 'human')),
						td(null, $menu),
					));
				}

			close('tbody');
			close('table');
		} else Tag::p(array("content" => $locales->trans('impro_discussion_no_topics')));

	close('div');
close('div');
