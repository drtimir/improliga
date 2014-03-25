pwf.rc({
	'name':'team_browser',
	'parents':['list_browser'],
	'proto':{
		'model':'Impro::Team'
	},

	'storage':{
		'opts':{
			'per_page':15,
			'filters':[
				{
					'name':'search',
					'type':'text',
					'placeholder':'Filtrovat'
				}
			],
			'after_render':function() {
				pwf.responsive.reset();
			}
		}
	},

	'init':function(proto)
	{
		proto.storage.renderer = pwf.create('list_renderer', {
			'template':'team'
		});
	},

	'public':{

	}
});
