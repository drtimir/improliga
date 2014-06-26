pwf.rc('ui.shows.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Seznam představení',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':15,
			'ui_filters':[
				{
					'name':'search',
					'type':'text',
					'placeholder':'Vyhledat',
					'attrs':['name', 'desc_full']
				}
			],
			'filters':[
				{'attr':'type', 'type':'exact', 'exact':[1,2,3,4]},
				{'attr':'published', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'start', 'mode':'desc'},
				{'attr':'start_time', 'mode':'desc'}
			]
		}
	}
});
