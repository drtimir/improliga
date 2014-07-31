pwf.rc('ui.intra.team.settings.locations', {
	'parents':['ui.intra.team.settings.abstract.loader'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['hq', 'loc_trainings'],
			'heading':''
		}
	}
});
