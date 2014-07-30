pwf.rc('ui.intra.team.settings.locations', {
	'parents':['adminer.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['hq', 'loc_trainings'],
			'heading':''
		}
	}
});
