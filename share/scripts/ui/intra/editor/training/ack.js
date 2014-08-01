pwf.rc('ui.intra.editor.training.ack', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Training::Ack',
			'exclude':['canceled'],
			'heading':'team-attd-respond',
			'inputs':{
				'training':{'type':'hidden'},
				'member':{'type':'hidden'},
				'user':{'type':'hidden'},
				'status':{
					'options':[
						{'name':'intra_team_attd_yes','value':3},
						{'name':'intra_team_attd_no','value':4},
						{'name':'intra_team_attd_maybe','value':5}
					]
				}
			}
		}
	}
});
