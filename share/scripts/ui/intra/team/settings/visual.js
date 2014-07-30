pwf.rc('ui.intra.team.settings.visual', {
	'parents':['adminer.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['logo', 'photo'],
			'heading':''
		}
	}
});
