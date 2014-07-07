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

		'construct':function(proto) {
			this.get_el('content').create_divs(['items', 'teams']);
		}
	},


	'public':{
		'load':function(proto, next) {
			var list = pwf.create('model.list', {
				'model':'Impro::Team::Member',
				'join':['team'],
				'filters':[
					//~ {'id_user':
				]
			});

			list.load(function(ctrl, next) {
				return function(err, response) {
					v(err, response);
				};
			}(this, next));
		}
	}
});
