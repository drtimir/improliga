pwf.rc('ui.intra.sections.home.teams', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':' ',
			'model':'Impro::Team::Member',
			'draw':'ui.intra.sections.home.team_list.member',
			'join':['team'],
			'filters':[],
			'sort':[]
		}
	},


	'init':function(proto)
	{
		proto.storage.opts.filters.push({
			'type':'exact',
			'attr':'id_system_user',
			'exact':pwf.site.get_user().get('id')
		});
	},


	'proto':{

	}
});
