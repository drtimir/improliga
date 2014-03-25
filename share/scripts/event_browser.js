pwf.rc({
	'name':'event_browser',
	'parents':['list_browser'],
	'proto':{
		'model':'Impro::Event'
	},

	'storage':{
		'opts':{
			'per_page':10,
			'sort':['start desc'],
			'filters':[
				{
					'name':'month',
					'type':'month',
					'value':pwf.moment(),
					'required':true
				}
			],
			'after_render':function() {
				pwf.responsive.reset();
			}
		},
	},

	'init':function(proto)
	{
		proto.storage.renderer = pwf.create('list_renderer', {
			'template':'event'
		});
	},

	'public':{

	}
});
