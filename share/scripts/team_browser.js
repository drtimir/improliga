pwf.rc({
	'name':'team_browser',
	'parents':['list_browser'],
	'proto':{
		'model':'Impro::Team'
	},

	'storage':{
		'opts':{
			'filters':[
				{
					'name':'search',
					'type':'text',
					'placeholder':'Filtrovat'
				}
			]
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
