pwf.rc('ui.intra.menu.main', {
	'parents':['ui.intra.menu.abstract'],

	'proto':{
		'items':[
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
				'name':'menu-shares',
				'url':'share'
			}
		],


		'construct':function(proto)
		{
			this.get_el('content').create_divs(['items', 'teams'], 'main-menu');

			proto('construct_items');
		},


		'construct_items':function(proto)
		{
			var items = proto('items');

			for (var i = 0; i < items.length; i++) {
				proto('construct_item', items[i]);
			}
		},


		'construct_item':function(proto, item)
		{
			var el = pwf.jquery.div('main-menu-item').create_divs(['icon', 'name']);

			el.name.html(pwf.locales.trans(item.name));
			this.get_el('content').items.append(el);
		},


		'construct_teams':function(proto, members)
		{
			for (var i = 0; i < members.length; i++) {
				proto('construct_team', members[i].get('team'));
			}
		},


		'construct_team':function(proto, item)
		{
			var el = pwf.jquery.div('team').create_divs(['logo', 'name']);

			el.name.html(item.get('name'));
			this.get_el('content').teams.append(el);
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
