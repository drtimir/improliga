pwf.rc('ui.abstract.popup.editor', {
	'parents':['el.popup', 'adminer.editor'],

	'storage':{
		'opts':{
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
	},

	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_popup');
		},


		'construct':function(proto)
		{
			proto('construct_ui');
			proto('construct_heading');
			proto('construct_form');
		},


		'construct_ui':function(proto)
		{
			var el = this.get_el().create_divs(['heading', 'cf'], 'adminer-editor');

			el.popup.inner
				.append(el.heading)
				.append(el.cf);
		}
	}
});
