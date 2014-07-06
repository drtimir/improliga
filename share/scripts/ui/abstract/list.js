pwf.rc('ui.abstract.list', {
	'parents':['adminer.list', 'ui.abstract.el'],

	'storage':{
		'filter':null,
		'opts':{
			'center':false,
			'model':null,
			'draw':null,
			'filters':[],
			'ui_filters':[]
		}
	},


	'proto':{
		'pagi_dest':['bottom'],

		'construct':function(proto) {
			proto('update_classes');
			proto('create_base');
			proto('create_heading');
			proto('create_container');
			proto('create_head');
			proto('create_filters');
			proto('create_pagi');
		},


		'update_heading':function(proto)
		{
			this.get_el('header').html(this.get('heading'));
		},


		'redraw':function(proto) {
			var list = this.get_data();

			this.get_el('content').html('');

			for (var i = 0; i < list.data.length; i++) {
				proto('draw_item', list.data[i], i);
			}

			this.get_el('content').append(pwf.jquery.span('cleaner'));
		},


		'get_ui_comp':function()
		{
			return this.get('draw');
		},


		'draw_item':function(proto, item, index)
		{
			var
				target = this.get_el('content'),
				el = pwf.jquery.div('ui-list-item').css('opacity', 0).appendTo(target),
				opts = pwf.merge({
					'parent':el,
					'item':item
				}, item.get_data()),
				obj = pwf.create(proto('get_ui_comp', item), opts);

			setTimeout(function(ctrl) {
				return function() {
					el.animate({'opacity':1}, 100);
					ctrl.get_el().trigger('resize');
				};
			}(this), index*25);
		}
	},


	'public':{

	}
});
