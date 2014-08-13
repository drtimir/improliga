pwf.rc('ui.intra.team.settings.members.invitations.invited', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'model':'Impro::User::Alert',
			'draw':'ui.intra.team.settings.members.member.invited',
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
				},
				{
					'attr':'canceled',
					'type':'exact',
					'exact':false
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
