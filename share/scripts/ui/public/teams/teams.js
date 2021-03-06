pwf.rc('ui.public.teams.teams', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Seznam týmů',
			'model':'Impro::Team',
			'draw':'ui.list.team',
			'per_page':12,
			'center':true,
			'ui_filters':[
				{
					'name':'accepting',
					'type':'checkbox',
					'label':'Pouze přijímající',
					'get_filter':function() {
						if (this.val()) {
							return {
								'attr':'accepting',
								'type':'exact',
								'exact':true
							};
						}

						return null;
					}
				},
				{
					'name':'search',
					'type':'text',
					'placeholder':'Vyhledat',
					'attrs':['name', 'city']
				}
			],
			'filters':[
				{'attr':'published', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'name'}
			]
		}
	}
});
