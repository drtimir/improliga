pwf.rc('ui.intra.sections.home.news', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Novinky',
			'model':'Impro::News',
			'draw':'ui.list.news',
			'per_page':6,
			'filters':[
				{'attr':'visible', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'created_at', 'mode':'desc'}
			]
		}
	}
});
