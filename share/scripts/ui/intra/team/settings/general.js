pwf.rc('ui.intra.team.settings.general', {
	'parents':['ui.intra.team.settings.abstract.loader'],

	'storage':{
		'opts':{
			'model':'Impro::Team',
			'attrs':['name', 'name_full', 'city', 'mail', 'site', 'about'],
			'heading':''
		}
	}
});
