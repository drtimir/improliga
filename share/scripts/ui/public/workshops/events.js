pwf.rc('ui.workshops.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Veřejné workshopy',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':6,
			'reverse':true,
			'center':true,
			'join':['location'],
			'ui_filters':[
				{
					'name':'from-future',
					'label':'Pouze budoucí',
					'type':'checkbox',
					'value':true,
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
