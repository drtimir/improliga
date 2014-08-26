pwf.rc('ui.intra.team.training.latest', {
	'parents':['ui.abstract.list'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Training',
			'draw':'ui.intra.team.training.latest.message',
			'per_page':1,
			'sort':[{'attr':'start', 'type':'desc'}],
			'heading':'training-latest',
			'filters':[
				{'attr':'start', 'type':'gt', 'gt':pwf.moment()}
			]
		}
	},


	'init':function(proto) {
		proto.storage.opts.filters.push({
			'attr':'id_team',
			'type':'exact',
			'exact':this.get('team')
		});
	}
});
