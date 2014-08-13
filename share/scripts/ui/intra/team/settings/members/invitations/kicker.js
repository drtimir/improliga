pwf.rc('ui.intra.team.settings.members.invitations.kicker', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'heading':'Zrušit pozvánku',
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
