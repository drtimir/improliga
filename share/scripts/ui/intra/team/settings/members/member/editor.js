pwf.rc('ui.intra.team.settings.members.member.editor', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Member',
			'attrs':['roles'],
			'inputs':{
				'roles':{
					'type':'checkbox',
					'multiple':true
				}
			},

			'buttons':[
				{
					'type':'submit',
					'label':'adminer-save'
				},
				{
					'type':'button',
					'label':'cancel',
					'on_click':function(e) {
						this.close();
					}
				}
			],

			'after_save':function()
			{
				this.close();
			}
		}
	}
});
