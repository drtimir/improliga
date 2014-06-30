pwf.rc('ui.event.detail', {
	'parents':['adminer.abstract.object'],

	'storage':{
		'opts':{
			'attrs':['location', 'team_home', 'team_away'],
			'model':'Impro::Event'
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_backbone');
		},


		'loaded':function(proto)
		{
			proto('construct');
		},


		'construct':function(proto)
		{
			proto('construct_ui');
			proto('construct_participants');
		},


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

			proto('create_label', 'start', this.format_time(item.get('start'), item.get('start_time')));

			if (item.get('end')) {
				proto('create_label', 'end', this.format_time(item.get('end'), item.get('end_time')));
			}

			if (item.get('price')) {
				proto('create_label', 'price', this.format_price(item));
			}

			if (item.get('location')) {
				proto('create_label', 'location', this.format_location(item.get('location')));
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
		},


		'create_label':function(proto, name, val)
		{
			var
				el = this.get_el('labels'),
				item = pwf.jquery.div('event-label').create_divs(['label', 'value']);

			item.label.html(pwf.locales.trans('event-' + name));
			item.value.html(val);

			el.append(item);
		},
	},

	'public':{
		'format_time':function(proto, date, time)
		{
			var str = [];

			if (date) {
				str.push(date.format('D.M.YYYY'));
			}

			if (time) {
				str.push(time);
			}

			return str.join(' ');
		},


		'format_location':function(proto, loc)
		{
			var el = pwf.jquery.div('location').create_divs(['name', 'addr', 'site']);

			el.name.html(loc.get('name'));
			el.addr.html(loc.get('addr'));

			if (loc.get('site')) {
				el.site.html(pwf.jquery('<a/>').attr('href', loc.get('site')).html(loc.get('site')));
			}

			return el;
		},


		'format_price':function(proto, item)
		{
			var
				el = pwf.jquery.div('price');


			el.html(item.get('price') + ' Kč');

			return el;
		},


		'format_team':function(proto, team)
		{
			var
				url  = pwf.dispatcher.url('team_detail', {'item':team.get_seoname()});
				link = pwf.jquery('<a/>')
				.attr('href', url)
				.html(team.get('name'));

			return link;
		}
	}
});
