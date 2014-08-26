pwf.rc('ui.intra.menu.config', {
	'parents':['ui.abstract.menu.ui'],

	'storage':{
		'opts':{
			'heading':'menu-config',
			'items':[
				{
					'title':'intra-menu-config-personal',
					'ui':'ui.intra.menu.settings.personal'
				},
				{
					'title':'intra-menu-config-contacts',
					'ui':'ui.intra.menu.settings.contacts'
				},
				{
					'title':'intra-menu-config-password',
					'ui':'ui.intra.menu.settings.password'
				}
			],
		}
	}
});
