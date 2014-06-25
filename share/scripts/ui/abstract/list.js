pwf.rc('ui.abstract.list', {
	'parents':['domel', 'model.list'],


	'storage':{
		'opts':{
			'model':null,
			'draw':null
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_ui');
			proto('construct_extra');

			proto('update_heading');
			proto('update_footer');
		},


		'construct_ui':function(proto)
		{
			var el = this.get_el().create_divs(['inner', 'header', 'content', 'pagi', 'footer'], 'ui-list');
			el.inner
				.append(el.header)
				.append(el.content)
				.append(el.pagi)
				.append(el.footer);
		},


		'update_heading':function(proto)
		{
			this.get_el('header').html(this.get('heading'));
		},


		'loaded':function(proto)
		{
			proto('redraw');
		},


		'redraw':function(proto) {
			var list = this.get_data();

			for (var i = 0; i < list.data.length; i++) {
				proto('draw_item', list.data[i]);
			}

			this.get_el('content').append(pwf.jquery.span('cleaner'));
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
