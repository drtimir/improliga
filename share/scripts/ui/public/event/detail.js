pwf.rc('ui.public.event.detail', {
	'parents':['ui.abstract.detail'],

	'storage':{
		'opts':{
			'attrs':['location', 'team_home', 'team_away'],
			'preload':['location'],
			'model':'Impro::Event'
		}
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['marginer', 'inner', 'left', 'right', 'heading', 'teams', 'labels', 'desc_short', 'desc', 'image', 'map', 'cleaner'], 'event-detail');

			el.heading.addClass('heading');

			el.marginer.append(el.inner);
			el.inner
				.append(el.left)
				.append(el.right)
				.append(el.cleaner);

			el.left
				.append(el.heading)
				.append(el.teams)
				.append(el.labels)
				.append(el.desc_short)
				.append(el.desc);

			el.right
				.append(el.image)
				.append(el.map);
		},


		'construct_ui':function(proto)
		{
			var
				el   = this.get_el(),
				item = this.get('item');

			el.heading.html(item.get('name'));
			el.desc_short.html(item.get('desc_short'));
			el.desc.html(item.get('desc_full'));
			el.desc.html(el.desc.text());

			if (!el.desc_short.text()) {
				el.desc_short.remove();
			}

			if (item.get('image')) {
				el.image.html(pwf.thumb.create(item.get('image').path, el.image.width() + 'x' + el.image.height()));
			}

			proto('create_label', 'date', this.format_time(item.get('start')));
			proto('create_label', 'start', this.format_time(null, item.get('start_time')));

			if (item.get('end')) {
				proto('create_label', 'end', this.format_time(item.get('end'), item.get('end_time')));
			}

			if (item.get('price')) {
				proto('create_label', 'price', this.format_price(item));
			}

			if (item.get('location')) {
				proto('create_label', 'location', pwf.create('ui.location', item.get('location').get_data()));
				el.map.html();
			}
		},


		'construct_participants':function(proto)
		{
			var
				item = this.get('item'),
				el = this.get_el('teams'),
				wrap;

			if (item.get('type') == 2) {
				wrap = pwf.jquery.div('participants-match').create_divs(['heading', 'teams']);

				wrap.heading.html(pwf.locales.trans('event-match'));

				if (item.get('team_home')) {
					wrap.teams.create_divs(['home']);
					wrap.teams.home.html(this.format_team(item.get('team_home')));

					if (item.get('team_away')) {
						wrap.teams.create_divs(['vs', 'away']);
						wrap.teams.vs.html(pwf.locales.trans('vs'));
						wrap.teams.away.html(this.format_team(item.get('team_away')));
					}
				}
			}

			if (wrap) {
				el.html(wrap);
			}
		}
	}
});
