pwf.rc('ui.teams.teams', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Seznam týmů',
			'model':'Impro::Team',
			'draw':'ui.list.team',
			'per_page':20,
			'ui_filters':[
				{
					'name':'search',
					'type':'text',
					'placeholder':'Vyhledat',
					'attrs':['name', 'city']
				}
			],
			'filters':[
				{'attr':'visible', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'name'}
			]
		}
	}
});
