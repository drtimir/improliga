pwf.rc('ui.loader', {
	'parents':['domel', 'preloader'],
	'uses':['jquery'],

	'init':function(proto) {
		var el = this.get_el();

		el.create_divs(['container']);
		el.container.create_divs(['bar', 'value']);
		el.addClass('ui-loader').hide();
	},

	'proto':{
		'update':function(proto) {
			var
				status = this.get_status(),
				cont = this.get_el('container'),
				size = cont.width() * status.finished,
				css = {'width':size};

			cont.value.html(Math.round(status.finished*100) + '%');
			cont.bar.stop(true).animate(css, 200);
		},

		'failed':function() {
			var failed = this.get_failed();

			v('Failed to load:');

			for (var i = 0; i < failed.length; i++) {
				v(failed[i].get_src());
				v(failed[i].get('error'));
			}
		},

		'resize':function(proto) {
			var
				el   = this.get_el(),
				pos  = el.offset(),
				body = this.get('parent'),
				cont = this.get_el('container');

			cont.css({
				'left':proto('cnum', body.width(), cont.width()),
				'top':proto('cnum', body.height(), cont.height())
			});
		},

		'el_bind':function(proto) {
			pwf.jquery(window).bind('resize.ui-loader', proto, proto('callbacks').resize);
		},

		'unbind':function(proto) {
			pwf.jquery(window).unbind('resize.ui-loader');
		},

		'cnum':function(proto, range, inset) {
			return parseInt(range/2 - inset/2);
		},

		'callbacks':{
			'resize':function(e) {
				e.data('resize');
			}
		}
	},

	'public':{
		'display':function(proto) {
			this.get_el().show();

			proto('el_bind');
			proto('resize');

			return this;
		},

		'hide':function(proto) {
			this.get_el().stop(true, true).fadeOut(500, pwf.jquery.callback_remove);
		}
	}
});
