pwf.rc('ui.abstract.menu', {
	'parents':['domel', 'caller'],


	'proto':{
		'el_attached':function(proto) {
			proto('construct_base');
			proto('construct');
		},


		'construct_base':function(proto) {
			var el = this.get_el().create_divs(['menu_content', 'loader']);

			el
				.bind('click', this, proto('callbacks-abstract').hide)
				.hide();
		},


		'construct_item':function(proto, target, item)
		{
			var el = pwf.jquery.div('typical-menu-item main-menu-item')
				.create_divs(['icon', 'name'])
				.bind('click', {
					'title':pwf.locales.trans_msg(item.name),
					'url':item.url,
					'ctrl':this,
					'params':{}
				}, proto('callbacks-abstract').navigate);

			if (item.icon) {
				el.icon.html(pwf.jquery.icon(item.icon, '32x32'));
			}

			el.name.html(pwf.locales.trans(item.name));
			target.append(el);
		},


		'show_loader':function(proto) {
			this.get_el('loader').stop(true).fadeIn(250);
		},


		'hide_loader':function(proto) {
			this.get_el('loader').stop(true).fadeOut(250);
		},


		'callbacks-abstract':{
			'hide':function(e) {
				e.data.get_el().trigger('deactivate');
			},

			'navigate':function(e) {
				var
					params = e.data.params,
					url    = pwf.dispatcher.url(e.data.url, params);

				e.data.ctrl.get_el().trigger('navigate', {
					'origin':e.data.ctrl,
					'title':e.data.title,
					'name':'navigate',
					'url':url
				});
			},
		}
	},


	'public':{
		'center':function(proto) {
			var
				body = this.get_el(),
				cont = this.get_el('menu_content');

			cont.css('top', Math.round((body.height() - cont.height())/2));
			return this;
		},


		'show':function(proto, next) {
			this.get_el().stop(true).fadeIn(250, function(ctrl, next) {
				return function() {
					ctrl.center().respond(next);
				};
			}(this, next));

			return this.center();
		},


		'hide':function(proto, next) {
			this.get_el().stop(true).fadeOut(250, function(ctrl, next) {
				return function() {
					ctrl.respond(next);
					ctrl.remove();
				};
			}(this, next));

			return this;
		}
	}
});
