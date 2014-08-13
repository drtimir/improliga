pwf.rc('ui.intra.team.settings.members.invitations.kicker', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'model':'Impro::User::Alert',
			'attrs':['canceled'],
			'inputs':{
				'canceled':{
					'type':'hidden',
					'value':true
				}
			}
		}
	}
});
