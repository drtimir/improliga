pwf.rc('ui.workshops.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Veřejné workshopy',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':20,
			'filters':{
				'type':[5]
			},
			'sort':[
				{'attr':'start', 'mode':'desc'},
				{'attr':'start_time', 'mode':'desc'}
			]
		}
	}
});
