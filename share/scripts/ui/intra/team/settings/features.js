pwf.rc('ui.intra.team.settings.features', {
	'parents':['adminer.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['accepting', 'use_discussion', 'use_attendance'],
			'heading':''
		}
	}
});
