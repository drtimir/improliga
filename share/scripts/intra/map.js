pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.setup({
		'map':[
			{
				'name':'home',
				'anchor':'/{section:string}?',
				'cname':'ui.structure.home',
				'structure':[
				]
			},

			{
				'name':'show_detail',
				'anchor':'/predstaveni/{item:seoname}',
				'structure':['ui.event']
			},

			{
				'name':'team_detail',
				'anchor':'/tymy/{item:seoname}',
				'structure':['ui.team.']
			}
		],

		'on_load':function(next) {
			var
				el    = pwf.site.get_el(),
				cname = this.get('cname') || 'ui.structure.section',
				opts  = pwf.merge({
					'parent':el,
					'structure':this.get('structure'),
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
			this.get('content').update(this.get('attrs')).redraw(next);
		},

		'on_error':function() {
			v('page-not-found');
		}
	});

});
