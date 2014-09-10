pwf.rc('ui.intra.menu.profile', {
	'parents':['ui.abstract.list', 'ui.abstract.menu'],

	'storage':{
		'opts':{
			'model':'Impro::User::Alert',
			'heading':'Upozornění',
			'draw':'ui.intra.alert',
			'join':['author', 'event', 'event', 'team', 'member', 'training'],
			'per_page':20,
			'filters':[],

			'ui_filters':[
				'type',
				{
					'name':'read',
					'label':'Stav',
					'type':'checkbox',
					'multiple':true,
					'value':[0],
					'options':[
						{
							'name':'Nepřečtené',
							'value':0
						},
						{
							'name':'Přečtené',
							'value':1
						}
					]
				}
			]
		}
	},


	'init':function(p)
	{
		p.storage.opts.filters.push({
			'attr':'id_user',
			'type':'exact',
			'exact':pwf.site.get_user().get('id')
		});

		p.storage.opts.ui_filters.push({
			'name':'id_team',
			'label':'Tým',
			'type':'checkbox',
			'multiple':true,
			'value':[],
			'options':pwf.site.get_user_teams()
		});
	},


	'proto':{
		'create_base':function(p)
		{
			var el = this.get_el();

			el.create_divs(['marginer', 'inner', 'profile', 'right', 'header', 'filter', 'pagi_top', 'content', 'pagi_bottom', 'cleaner']);
			el.menu_content.append(el.marginer);
			el.filter.addClass('typical-menu');

			el.marginer
				.append(el.inner)
				.append(el.right)
				.append(el.cleaner);

			el.inner
				.append(el.profile)
				.append(el.filter);

			el.right
				.append(el.header)
				.append(el.pagi_top)
				.append(el.content)
				.append(el.pagi_bottom);

			p('create_profile');
			p('bind');
		},


		'create_profile':function(p)
		{
			var el = this.get_el('profile');

			el.create_divs(['avatar', 'data', 'cleaner'], 'profile');

			el.cleaner.addClass('cleaner');
			el.data.create_divs(['name', 'link']);
			el.data.name.html(pwf.site.get_user_name());

			pwf.thumb.fit(pwf.site.get_user_avatar().path, el.avatar);
		},


		'bind':function(p)
		{
			var callback = function(e) {
				e.stopPropagation();
			};

			this.get_el('inner').bind('click', callback);
			this.get_el('right').bind('click', callback);
		}
	},


	'public':{
	}
});
