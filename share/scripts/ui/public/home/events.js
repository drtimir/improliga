pwf.rc('ui.public.home.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'center':true,
			'heading':'Nejbližší události',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':6,
			'join':['location'],
			'filters':[
				{'attr':'published', 'type':'exact', 'exact':true},
				{'attr':'start', 'type':'gte', 'gte':pwf.moment().format('YYYY-MM-DD')}
			],
			'sort':[
				{'attr':'start', 'mode':'desc'},
				{'attr':'start_time', 'mode':'desc'}
			]
		}
	},


	'proto':{
		'update_footer':function() {
			this.get_el('footer').html(pwf.jquery('<a/>').html('Seznam událostí'));
		}
	}
});
