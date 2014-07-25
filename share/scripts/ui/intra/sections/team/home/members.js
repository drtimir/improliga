pwf.rc('ui.intra.sections.team.home.members', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Členové',
			'model':'Impro::Team::Member',
			'draw':'ui.list.team.member',
			'per_page':30,
			'join':['user']
		}
	},


	'init':function(proto)
	{
		proto.storage.opts.filters.push({
			'attr':'id_impro_team',
			'type':'exact',
			'exact':this.get('team')
		});
	}
});
