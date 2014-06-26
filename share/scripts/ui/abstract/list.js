pwf.rc('ui.abstract.list', {
	'parents':['adminer.list'],


	'storage':{
		'filter':null,
		'opts':{
			'model':null,
			'draw':null,
			'filters':[],
			'ui_filters':[]
		}
	},


	'proto':{
		'pagi_dest':['bottom'],

		'update_heading':function(proto)
		{
			this.get_el('header').html(this.get('heading'));
		},


		'redraw':function(proto) {
			var list = this.get_data();

			this.get_el('content').html('');

			for (var i = 0; i < list.data.length; i++) {
				proto('draw_item', list.data[i]);
			}

			this.get_el('content').append(pwf.jquery.span('cleaner'));
			this.get_el().trigger('resize');
		},


		'get_ui_comp':function()
		{
			return this.get('draw');
		},


		'draw_item':function(proto, item)
		{
			var opts = pwf.merge({
				'parent':this.get_el('content'),
				'item':item
			}, item.get_data());


			pwf.create(proto('get_ui_comp', item), opts);
		}
	},


	'public':{

	}
});
