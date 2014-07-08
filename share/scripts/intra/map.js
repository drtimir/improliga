pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.setup({
		'map':[
			{
				'name':'home',
				'anchor':'/',
				'cname':'ui.structure.section',
				'structure':[
				]
			},

			{
				'name':'teams',
				'anchor':'/tymy',
				'cname':'ui.structure.section',
				'structure':['ui.intra.team.list']
			},

			{
				'name':'team',
				'anchor':'/tymy/{item:seoname}',
				'structure':['ui.team']
			},


			{
				'name':'contacts',
				'anchor':'/kontakty',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'shows',
				'anchor':'/predstaveni',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'show',
				'anchor':'/predstaveni/{item:seoname}',
				'structure':['ui.event']
			},

			{
				'name':'workshops',
				'anchor':'/workshopy',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'workshop',
				'anchor':'/workshopy/{item:seoname}',
				'structure':['ui.event']
			},

			{
				'name':'discussions',
				'anchor':'/diskuze',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'shared',
				'anchor':'/sdilene',
				'cname':'ui.structure.section',
				'structure':[]
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
