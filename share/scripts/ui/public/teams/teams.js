pwf.rc('ui.teams.teams', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'heading':'Seznam týmů',
			'model':'Impro::Team',
			'draw':'ui.list.team',
			'per_page':50,
			'filters':[
				{'attr':'visible', 'type':'exact', 'exact':true}
			]
		}
	}
});
