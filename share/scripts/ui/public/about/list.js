pwf.rc('ui.about.list', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Články',
			'model':'Impro::Article',
			'draw':'ui.list.article'

		}
	}
});
