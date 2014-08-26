pwf.rc('ui.intra.menu.create', {
	'parents':['ui.abstract.menu.ui'],

	'storage':{
		'opts':{
			'heading':'menu-create',
			'items':[
				{
					'title':'menu-create-event',
					'ui':'ui.intra.editor.event'
				},
				{
					'title':'menu-create-training',
					'ui':'ui.intra.editor.training'
				}
			],
		}
	}
});
