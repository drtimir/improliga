pwf.rc('ui.team.detail', {
	'parents':['ui.abstract.detail'],

	'storage':{
		'opts':{
			'attrs':[],
			'model':'Impro::Team'
		}
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['marginer', 'inner', 'left', 'right', 'info', 'logo', 'heading', 'name_full', 'notice', 'labels', 'desc', 'image', 'events', 'cleaner'], 'team-detail');

			el.heading.addClass('heading');

			el.marginer.append(el.inner);
			el.inner
				.append(el.image)
				.append(el.left)
				.append(el.right)
				.append(el.cleaner);

			el.info
				.append(el.heading)
				.append(el.name_full)
				.append(el.labels);

			el.left
				.append(el.logo)
				.append(el.info)
				.append(el.notice)
				.append(el.desc_short)
				.append(el.desc);

			el.right.append(el.events);
		},


		'construct_ui':function(proto)
		{
			var
				el   = this.get_el(),
				item = this.get('item');

			el.heading.html(item.get('name'));

			if (item.get('name') != item.get('name_full') && item.get('name_full')) {
				el.name_full.html(item.get('name_full'));
			} else {
				el.name_full.remove();
			}

			if (item.get('dissolved')) {
				el.notice.html(pwf.locales.trans('team-is-dissolved'));
			} else {
				if (item.get('accepting')) {
					el.notice.html(pwf.locales.trans('team-is-accepting'));
				}
			}

			if (item.get('city')) {
				proto('create_label', 'city', item.get('city'));
			}

			if (item.get('site')) {
				proto('create_label', 'site', this.link(item.get('site'), item.get('site')));
			}

			el.desc.html(item.get('about'));
			el.desc.html(el.desc.text());


			if (item.get('logo')) {
				pwf.thumb.fit(item.get('logo').path, el.logo);
			}

			if (item.get('photo')) {
				pwf.thumb.fit(item.get('photo').path, el.image);
			}

			pwf.create('ui.shows.events', {
				'parent':el.events,
				'ui_filters':[],
				'per_page':5,
				'filters':[
					{'attr':'type', 'type':'exact', 'exact':[1,2,3,4]},
					{'attr':'published', 'type':'exact', 'exact':true},
					{'type':'or', 'or':[
						{
							'attr':'team_home',
							'type':'exact',
							'exact':item.get('id')
						},
						{
							'attr':'team_away',
							'type':'exact',
							'exact':item.get('id')
						}
					]}
				]
			}).load();
		}
	}
});
