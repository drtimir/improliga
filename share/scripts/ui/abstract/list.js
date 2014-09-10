pwf.rc('ui.abstract.list', {
	'parents':['adminer.list', 'ui.abstract.el'],

	'storage':{
		'filter':null,
		'opts':{
			'center':false,
			'model':null,
			'draw':null,
			'draw_empty':'ui.abstract.list.empty',
			'filters':[],
			'ui_filters':[]
		}
	},


	'proto':{
		'pagi_dest':['bottom'],

		'construct':function(p) {
			p('update_classes');
			p('create_base');
			p('create_heading');
			p('create_container');
			p('create_head');
			p('create_filters');
			p('create_pagi');
		},


		'create_head':function() {
		},


		'create_container':function() {
			this.get_el('content').append(pwf.jquery.span('cleaner'));
		},


		'update_heading':function(p)
		{
			this.get_el('header').html(this.get('heading'));
		},


		'redraw':function(p, next) {
			var
				el = this.get_el('content.inner'),
				children = el.children('.ui-list-item'),
				list = this.get_data(),
				jobs = [];

			jobs.push(function(next) {
				p('hide_items', next);
			});

			jobs.push(function(next) {
				if (list.data.length) {
					p('draw_items', next);
				} else {
					p('draw_empty', next);
				}
			});

			pwf.async.series(jobs, function(ctrl, next) {
				return function(err) {
					ctrl.get_el('content')
						.trigger('resize');

					ctrl.respond(next, err);
				};
			}(this, next));
		},


		'hide_items':function(p, next)
		{
			var
				el = this.get_el('content.inner'),
				children = el.children('.ui-list-item'),
				jobs = [];

			el.find('.ui-abstract-list-empty').remove();

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


		'draw_items':function(p, next)
		{
			var
				list = this.get_data(),
				jobs = [];

			for (var i = 0; i < list.data.length; i++) {
				jobs.push(function(item, index) {
					return function(next) {
						p('draw_item', item, index, next);
					};
				}(list.data[i], i));
			}

			pwf.async.parallel(jobs, function(ctrl, next) {
				return function() {
					ctrl.respond(next);
				};
			}(this, next));
		},


		'draw_empty':function(p, next)
		{
			var obj = pwf.create(this.get('draw_empty'), {
				'parent':this.get_el('content.inner'),
				'ref':this
			});

			obj.get_el().css('opacity', 0);


			setTimeout(function(ctrl, next) {
				return function() {
					obj.get_el().animate({'opacity':1}, 100, next);
				};
			}(this, next), 25);
		},


		'get_ui_comp':function()
		{
			return this.get('draw');
		},


		'draw_item':function(p, item, index, next)
		{
			var
				target = this.get_el('content.inner'),
				opts = pwf.merge({
					'ref':this,
					'parent':target,
					'item':item
				}, item.get_data()),
				obj = pwf.create(p('get_ui_comp', item), opts);

			obj.get_el()
				.addClass(index%2 ? 'odd':'even')
				.addClass('ui-list-item')
				.css('opacity', 0);

			setTimeout(function(ctrl, next) {
				return function() {
					obj.get_el().animate({'opacity':1}, 100, next);
				};
			}(this, next), index*25);
		}
	},


	'public':{

	}
});
