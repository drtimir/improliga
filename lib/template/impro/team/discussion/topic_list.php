<?

Tag::div(array("class" => 'discussion topic_list'));

	echo $ren->heading($heading);

	echo ul('controls plain', array(
		li($ren->label_for_url('team_discussion_topic_create', $locales->trans('intra_team_discussion_topic_create'), 'godmode/actions/create', 16, args($team))),
	));

	echo div('topics');
		if (any($topics)) {
			Tag::table(array("class" => 'topic_table'));
			Tag::thead();
				Tag::tr();
					Tag::th(array("class" => 'topic', "content" => $locales->trans('impro_discussion_topic')));
					Tag::th(array("class" => 'last', "content" => $locales->trans('impro_discussion_last_author')));
					Tag::th(array("class" => 'date', "content" => $locales->trans('impro_discussion_updated_at')));
					Tag::th();
				close('tr');
			close('thead');

			Tag::tbody();
				foreach ($topics as $topic) {
					Tag::tr();
						Tag::td(array("content" => $ren->link_for('team_discussion_topic', $topic->name, args($team, $topic))));
						Tag::td(array("content" => $topic->last_post_author ? Impro\User::link($ren, $topic->last_post_author):'-'));
						Tag::td(array("content" => $locales->format_date($topic->updated_at, 'human')));

						if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE) || $topic->author->id == $request->user->id) {
							Tag::td(array(
								"content" => array(
									$ren->icon_for_url('team_discussion_topic_edit', 'impro/actions/edit', 16, args($team, $topic)),
									$ren->icon_for_url('team_discussion_topic_delete', 'impro/actions/delete', 16, args($team, $topic)),
								),
							));
						}

					close('tr');
				}

			close('tbody');
			close('table');
		} else Tag::p(array("content" => $locales->trans('intra_team_discussion_no_topics')));

	close('div');
close('div');
