pwf.rc('ui.intra.team.settings.general', {
	'parents':['adminer.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['name', 'name_full', 'logo', 'photo', 'city', 'mail', 'site', 'about'],
			'heading':''
		}
	}
});
