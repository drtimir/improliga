pwf.rc('ui.intra.sections.team.header', {
	"parents":['ui.abstract.detail'],

	"storage":{
		"opts":{
			'model':'Impro::Team'
		}
	},


	'init':function(proto)
	{
		this.set('item', this.get('vars.team'));
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['logo', 'name', 'menu', 'cleaner']);

			el.name.create_divs(['long', 'short']);
		},


		'construct':function(proto)
		{
			proto('fill_data');
			proto('fill_menu');
		},


		'fill_data':function(proto)
		{
			var
				item = this.get('item'),
				el = this.get_el();

			el.name.short.html(item.get('name'));
			el.name.long.html(item.get('name_full'));
			pwf.thumb.fit(item.get('logo').path, el.logo);
		},


		'fill_menu':function(proto)
		{
			proto('create_menu_item', {
				'label':'overview',
				'url':'team'
			});

			proto('create_menu_item', {
				'label':'shows',
				'url':'team_shows'
			});

			proto('create_menu_item', {
				'label':'workshops',
				'url':'team_workshops'
			});

			proto('create_menu_item', {
				'label':'discussion',
				'url':'team_discussion',
				'settings':'use_discussion',
				'groups':[1,2,3,4,5,6,7,8,9]
			});

			proto('create_menu_item', {
				'label':'settings',
				'url':'team_settings',
				'groups':[2]
			});

			proto('create_menu_item', {
				'label':'attendance',
				'url':'team_attendance',
				'settings':'use_attendance',
				'groups':[2,3,4,7]
			});
		},


		'create_menu_item':function(proto, opts)
		{
			var
				allowed = true,
				item;

			if (typeof opts.settings != 'undefined') {
				allowed = !!this.get('item').get(opts.settings);
			}

			if (allowed && (typeof opts.groups != 'undefined')) {
				allowed = allowed && !!pwf.site.is_user_member_in(this.get('item'), opts.groups);
			}

			if (allowed) {
				item = pwf.jquery('<a/>')
					.html(pwf.locales.trans('team-menu-' + opts.label))
					.addClass('team-menu-item')
					.appendTo(this.get_el('menu'))
					.attr('href', pwf.dispatcher.url(opts.url, {
						'team':this.get('item').get_seoname()
					}));
			}

			return item;
		}
	}


});
