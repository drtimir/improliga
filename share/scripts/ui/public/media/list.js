pwf.rc('ui.public.media.list', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Co o Improlize píší média',
			'model':'Impro::Media::Article',
			'draw':'ui.list.media_article',
			'per_page':6,
			'center':true,
			'filters':[
				{'attr':'published', 'type':'exact', 'exact':true}
			],
			'sort':[
				{'attr':'date', 'mode':'desc'}
			]
		}
	},

	'proto':{
	}
});
