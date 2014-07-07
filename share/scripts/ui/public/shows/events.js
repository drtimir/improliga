pwf.rc('ui.public.shows.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Představení',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':12,
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
