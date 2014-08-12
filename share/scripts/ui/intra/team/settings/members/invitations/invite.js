pwf.rc('ui.intra.team.settings.members.invitations.invite', {
	'parents':['ui.abstract.el'],

	'storage':{
		'opts':{
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_form');
		},


		'construct_form':function(proto)
		{
			proto.storage.form = pwf.create('form', {
				'parent':this.get_el(),
				'action':pwf.dispatcher.url('api_team_member_invite', {
					'team':this.get('team-seoname')
				}),
				'heading':pwf.locales.trans('team-member-invite'),
				'elements':[
					{
						'name':'name',
						'type':'email',
						'required':true,
						'label':pwf.locales.trans('enter-email'),
					},
					{
						'element':'button',
						'type':'submit',
						'label':pwf.locales.trans('invite')
					}
				]
			});
		}
	},
});
