<?

echo div('discussion post_list');

	echo $ren->heading($ren->link_for('team_discussion_topic', $topic->name, args($team, $topic)));
	echo div('desc', to_html($ren, $topic->desc));

	echo div('post_form');
		$ren->slot('discussion_post_form');
	close('div');


	echo ul('posts plain');

		foreach ($posts as $post) {

			if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE) || $topic->author->id == $request->user->id) {
				$opts = array();

				if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_MODERATE)) {
					$opts[] = li($ren->icon_for_url('team_discussion_post_edit', 'godmode/actions/edit', 16, args($team, $topic, $post)));
				}

				$opts[] = li($ren->icon_for_url('team_discussion_post_delete', 'godmode/actions/delete', 16, args($team, $topic, $post)));
				$menu = ul('plain menu-moderator', $opts);
			} else {
				$menu = '';
			}

			echo li(array(
				div('avatar', Impro\User::avatar($ren, $post->author)),
				div('author', array(
					Impro\User::link($ren, $post->author),
					$ren->link('#post_'.$post->id, $locales->format_date($post->created_at, 'human'), array("class" => 'link-date')),
					$menu,
				)),
				div('text', $post->text ? to_html($ren, $post->text):'<p class="gray">Prázdný příspěvek</p>'),
			), 'post', 'post_'.$post->id);
		}

	close('ul');
close('div');
