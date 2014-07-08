pwf.rc('ui.intra.menu.main', {
	'parents':['ui.abstract.menu'],

	'proto':{
		'items':[
			{
				'name':'menu-home',
				'url':'home'
			},
			{
				'name':'menu-teams',
				'url':'teams'
			},
			{
				'name':'menu-contacts',
				'url':'contacts'
			},
			{
				'name':'menu-shows',
				'url':'shows'
			},
			{
				'name':'menu-workshops',
				'url':'workshops'
			},
			{
				'name':'menu-discussions',
				'url':'discussions'
			},
			{
				'name':'menu-shared',
				'url':'shared'
			}
		],


		'construct':function(proto)
		{
			var el = this.get_el('menu_content').create_divs(['items', 'teams', 'cleaner'], 'main-menu').addClass('typical-menu');
			el.cleaner.addClass('cleaner');

			proto('construct_items');
		},


		'construct_items':function(proto)
		{
			var items = proto('items');

			for (var i = 0; i < items.length; i++) {
				proto('construct_item', this.get_el('menu_content').items, {
					'icon':items[i].name,
					'name':'intra-' + items[i].name,
					'url':items[i].url
				});
			}
		},


		'construct_teams':function(proto, members)
		{
			for (var i = 0; i < members.length; i++) {
				proto('construct_team', members[i].get('team'));
			}
		},


		'construct_team':function(proto, item)
		{
			proto('construct_item', this.get_el('menu_content').teams, {
				'icon':item.get('logo'),
				'name':item.get('name')
			});
		}
	},


	'public':{
		'load':function(proto, next) {
			var list = pwf.create('model.list', {
				'model':'Impro::Team::Member',
				'join':['team'],
				'filters':[
					{'attr':'id_system_user', 'type':'exact', 'exact':pwf.site.get_user().get('id')}
				]
			});

			list.load(function(ctrl, proto, next) {
				return function(err, response) {
					if (err) {
						this.get_el().trigger('network-error', {
							'error':err,
							'origin':this
						});
					} else {
						proto('construct_teams', response.data);
					}
				};
			}(this, proto, next));
		}
	}
});
