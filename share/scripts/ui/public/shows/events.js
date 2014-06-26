pwf.rc('ui.shows.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Naplánované události',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':20,
			'ui_filters':['name'],
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
