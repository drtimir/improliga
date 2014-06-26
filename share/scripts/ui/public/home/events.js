pwf.rc('ui.home.events', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Nejbližší události',
			'model':'Impro::Event',
			'draw':'ui.list.event',
			'per_page':6,
			'ui_filters':['name'],
			'filters':[
				{'attr':'type', 'type':'in', 'in':[1,2,3,4]},
				{'attr':'published', 'type':'exact', 'exact':true}
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
