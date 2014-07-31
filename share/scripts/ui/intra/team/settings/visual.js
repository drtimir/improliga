pwf.rc('ui.intra.team.settings.visual', {
	'parents':['ui.intra.team.settings.abstract.loader'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['logo', 'photo'],
			'heading':''
		}
	}
});
