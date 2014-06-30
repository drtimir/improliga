pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.setup({
		'map':[
			{
				'name':'home',
				'anchor':'/{section:string}?',
				'cname':'ui.structure.home',
				'structure':[
					{
						'cname':'ui.structure.section',
						'pass':{
							'structure':['ui.home']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'link':'o-improlize',
							'structure':['ui.about']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'link':'predstaveni',
							'structure':['ui.shows']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'link':'tymy',
							'structure':['ui.teams']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'link':'workshopy',
							'structure':['ui.workshops']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'link':'media-o-improlize',
							'structure':['ui.media']
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'link':'kontakty',
							'structure':['ui.contact']
						}
					}
				]
			},
			{
				'name':'show_detail',
				'anchor':'/predstaveni/.+\-{item:int}',
				'structure':['ui.event']
			}
		],

		'on_load':function(next) {
			var
				el    = pwf.site.get_el(),
				cname = this.get('cname') || 'ui.structure.section',
				opts  = pwf.merge({
					'parent':el,
					'structure':this.get('structure'),
					'vars':this.get('attrs'),
					'on_load':function() {
						el.trigger('resize');

						pwf.jquery('html,body').stop(true).scrollTo(el.offset().top, 750, function(el) {
							return function() {
								el.trigger('scroll');
							};
						}(el));
					}
				}, this.get('attrs'));

			el.html('').trigger('loading');

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
