pwf.rc('ui.intra.team.settings.features', {
	'parents':['ui.intra.team.settings.abstract.loader'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['accepting', 'use_discussion', 'use_attendance'],
			'heading':''
		}
	}
});
