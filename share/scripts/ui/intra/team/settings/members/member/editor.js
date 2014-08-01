pwf.rc('ui.intra.team.settings.members.member.editor', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Member',
			'attrs':['roles'],
			'inputs':{
				'roles':{
					'type':'checkbox',
					'multiple':true
				}
			}
		}
	}
});
