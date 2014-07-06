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


		'create_head':function() {
		},


		'update_heading':function(proto)
		{
			this.get_el('header').html(this.get('heading'));
		},


		'redraw':function(proto) {
			var
				el = this.get_el('content'),
				children = el.children('.ui-list-item'),
				jobs = [];

			jobs.push(function(next) {
				proto('hide_items', next);
			});

			jobs.push(function(next) {
				proto('draw_items', next);
			});

			pwf.async.series(jobs, function(ctrl) {
				return function() {
					ctrl.get_el('content')
						.append(pwf.jquery.span('cleaner'))
						.trigger('resize');
				};
			}(this));
		},


		'hide_items':function(proto, next)
		{
			var
				el = this.get_el('content'),
				children = el.children('.ui-list-item'),
				jobs = [];

			for (var i = 0; i < children.length; i++) {
				jobs.push(function(item, time) {
					return function(next) {
						setTimeout(function() {
							item.fadeOut(100, function() {
								item.remove();
								next();
							});
						}, time);
					};
				}(pwf.jquery(children[i]), (children.length-i)*25));
			}

			pwf.async.parallel(jobs, function(ctrl, next) {
				return function() {
					ctrl.respond(next);
				};
			}(this, next));
		},


		'draw_items':function(proto, next)
		{
			var
				list = this.get_data(),
				jobs = [];

			for (var i = 0; i < list.data.length; i++) {
				jobs.push(function(item, index) {
					return function(next) {
						proto('draw_item', item, index, next);
					};
				}(list.data[i], i));
			}

			pwf.async.parallel(jobs, function(ctrl, next) {
				return function() {
					ctrl.respond(next);
				};
			}(this, next));
		},


		'get_ui_comp':function()
		{
			return this.get('draw');
		},


		'draw_item':function(proto, item, index, next)
		{
			var
				target = this.get_el('content'),
				el = pwf.jquery.div('ui-list-item').css('opacity', 0).appendTo(target),
				opts = pwf.merge({
					'parent':el,
					'item':item
				}, item.get_data()),
				obj = pwf.create(proto('get_ui_comp', item), opts);

			setTimeout(function(ctrl, next) {
				return function() {
					el.animate({'opacity':1}, 100, next);
				};
			}(this, next), index*25);
		}
	},


	'public':{

	}
});
