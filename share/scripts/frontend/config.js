pwf.wi(['dispatcher'], function()
{
	pwf.dispatcher.setup({
				'on_load':function(next) {
				var
					el    = pwf.site.get_el(),
					cname = this.get('cname') || 'ui.structure.section',
					opts  = pwf.merge({
						'parent':el,
						'structure':this.get('structure'),
						'name':this.get('name'),
						'vars':this.get('attrs')
					}, this.get('attrs'));

				el
					.html('')
					.trigger('resize')
					.trigger('loading');

				this.set('content', pwf.create(cname, opts).load(function(err) {
					el.trigger('resize');
					el.trigger('ready');
					this.respond(next, [err]);
				}));
			},

			'on_redraw':function(next) {
				this.get('content').update(pwf.merge({'vars':this.get('attrs')}, this.get('attrs'))).redraw(next);
			},

			'on_error':function() {
				v('page-not-found');
			}
	});
});
