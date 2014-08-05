pwf.rc('ui.intra.team.settings.members.invited', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'model':'Impro::User::Alert',
			'draw':'ui.intra.team.settings.members.member',
			'heading':'team-cfg-member-invited-list',
			'filters':[
				{
					'attr':'read',
					'type':'exact',
					'exact':false
				},
				{
					'attr':'template',
					'type':'exact',
					'exact':[3,5]
				}
			],
		}
	},


	'init':function(proto)
	{
		proto.storage.opts.filters.push({
			'attr':'id_team',
			'type':'exact',
			'exact':this.get('team')
		});
	},
});
