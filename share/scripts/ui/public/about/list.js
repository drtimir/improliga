pwf.rc('ui.about.list', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'center':true,
			'heading':'Články',
			'model':'Impro::Article',
			'draw':'ui.list.article'
		}
	}
});
