pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.setup({
		'map':[
			{
				'name':'home',
				'anchor':'/{section:string}?',
				'cname':'ui.public.structure.home',
				'structure':[
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'home',
							'parallax':true,
							'structure':['ui.public.home']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'about',
							'link':'o-improlize',
							'structure':['ui.public.about']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'shows',
							'link':'predstaveni',
							'parallax':true,
							'structure':['ui.public.shows']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'teams',
							'link':'tymy',
							'structure':['ui.public.teams']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'workshops',
							'link':'workshopy',
							'parallax':true,
							'structure':['ui.public.workshops']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'media',
							'link':'media-o-improlize',
							'structure':['ui.public.media']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'bind':'contact',
							'link':'kontakty',
							'parallax':true,
							'structure':['ui.public.contact']
						}
					}
				]
			},

			{
				'name':'show_detail',
				'anchor':'/predstaveni/{item:seoname}',
				'structure':['ui.public.event']
			},

			{
				'name':'team_detail',
				'anchor':'/tymy/{item:seoname}',
				'structure':['ui.public.team']
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
