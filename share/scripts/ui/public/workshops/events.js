pwf.rc('ui.workshops.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Veřejné workshopy',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':20,
			'ui_filters':[
				{
					'name':'search',
					'type':'text',
					'placeholder':'Vyhledat',
					'attrs':['name', 'desc_full']
				}
			],
			'filters':[
				{'attr':'type', 'type':'exact', 'exact':5},
				{'attr':'published', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'start', 'mode':'desc'},
				{'attr':'start_time', 'mode':'desc'}
			]
		}
	}
});
