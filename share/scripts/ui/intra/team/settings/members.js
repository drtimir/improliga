pwf.rc('ui.intra.team.settings.members', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Member',
			'draw':'ui.intra.team.settings.members.member',
			'attrs':['name', 'name_full', 'city', 'mail', 'site', 'about'],
			'heading':'team-cfg-member-list',
			'join':['user', 'team'],
			'filters':[],
		}
	},


	'init':function(proto)
	{
		proto.storage.opts.filters.push({
			'attr':'id_impro_team',
			'type':'exact',
			'exact':this.get('item')
		});
	},
});
