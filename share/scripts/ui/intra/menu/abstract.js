pwf.rc('ui.intra.menu.abstract', {
	'parents':['domel', 'caller'],


	'proto':{
		'el_attached':function(proto) {
			proto('construct_base');
			proto('construct');
		},


		'construct_base':function(proto) {
			var el = this.get_el().create_divs(['content', 'loader']);

			el
				.bind('click', this, proto('callbacks').hide)
				.hide();

			el.content.bind('click', function(e) {
				e.stopPropagation();
			});
		},


		'show_loader':function(proto) {
			this.get_el('loader').stop(true).fadeIn(250);
		},


		'hide_loader':function(proto) {
			this.get_el('loader').stop(true).fadeOut(250);
		},


		'callbacks':{
			'hide':function(e) {
				e.data.get_el().trigger('deactivate');
			}
		}
	},


	'public':{
		'show':function(proto, next) {
			this.get_el().stop(true).fadeIn(250, function(ctrl, next) {
				return function() {
					ctrl.respond(next);
				};
			}(this, next));

			return this;
		},


		'hide':function(proto, next) {
			this.get_el().stop(true).fadeOut(250, function(ctrl, next) {
				return function() {
					ctrl.respond(next);
					ctrl.remove();
				};
			}(this, next));

			return this;
		},


		'load':function(proto, next) {
			this.respond(next);
		}
	}
});
