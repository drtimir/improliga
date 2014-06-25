pwf.rc('ui.shows.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Naplánované události',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':20,
			'filters':{
				'type':[1,2,3,4]
			},
			'sort':[
				{'attr':'start', 'mode':'desc'},
				{'attr':'start_time', 'mode':'desc'}
			]
		}
	}
});
