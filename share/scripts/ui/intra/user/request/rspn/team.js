pwf.rc('ui.user.request.rspn.team', {
	'parents':['form'],

	'storage':{
		'opts':{
			'heading':'request-enter-team',
			'desc':'request-enter-team-desc',
			'elements':[
				{
					'type':'hidden',
					'name':'alert'
				},
				{
					'type':'radio',
					'name':'response',
					'label':'Chcete se připojit k týmu?',
					'options':[
						{'name':'yes', 'value':1},
						{'name':'no', 'value':2}
					]
				},
				{
					'element':'button',
					'type':'submit',
					'label':'save',
				}
			],

			'on_ready':function(e, res) {
				v(res);
			}
		}
	},

	'init':function(p)
	{
		this.set('action', '/api/team/' + this.get('team').get('id') + '/join');
	}
});
