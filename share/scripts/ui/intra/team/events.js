pwf.rc('ui.intra.team.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Představení týmu',
			'model':'Impro::Event',
			'draw':'ui.list.team',
			'per_page':16,
			'ui_filters':[
				{
					'name':'from-future',
					'label':'Pouze budoucí',
					'type':'checkbox',
					'get_filter':function() {
						if (this.val()) {
							return {
								'attr':'start',
								'type':'gte',
								'gte':pwf.moment().format('YYYY-MM-DD')
							};
						}

						return null;
					}
				},
				{
					'name':'search',
					'type':'text',
					'placeholder':'Vyhledat',
					'attrs':['name', 'desc_full']
				}
			],
			'filters':[
				{'attr':'visible', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'name'}
			]
		}
	},


	'init':function(proto)
	{
		proto.storage.opts.filters.push({
			'type':'or',
			'or':[
				{
					'attr':'id_team_away',
					'type':'exact',
					'exact':this.get('team')
				},
				{
					'attr':'id_team_home',
					'type':'exact',
					'exact':this.get('team')
				}
			]
		});
	}
});
