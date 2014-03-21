pwf.rc({
	'name':'team_browser',
	'parents':['list_browser'],
	'proto':{
		'model':'Impro::Team'
	},

	'init':function(proto)
	{
		proto.storage.renderer = pwf.create('list_renderer', {
			'template':'team.ich'
		});
	},

	'public':{

	}
});
