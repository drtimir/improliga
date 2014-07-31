pwf.rc('ui.intra.menu.create.item', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'name':null,
			'editor':null
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			this.get_el()
				.addClass('typical-menu-item')
				.html(pwf.locales.trans(this.get('name')))
				.bind('click', this, proto('callbacks').use);
		},


		'callbacks':{
			'use':function(e) {
				e.stopPropagation();
				e.data.get_el().trigger('activate', e.data);
			}
		}
	}
});
