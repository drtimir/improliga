pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.map([
		{
			'name':'home',
			'anchor':'{section:string}?',
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
			'anchor':'predstaveni/.+\-{item:int}',
			'structure':['ui.event']
		}
	]);


	pwf.queue
		.on('dispatcher.load', function(pack) {
			var
				section,
				view    = pack.response.view,
				el      = pwf.site.get_el(),
				opts    = {
					'parent':el,
					'structure':view.get('structure'),
					'vars':view.get('attrs'),
					'on_load':function() {
						pwf.jquery('html,body').stop(true).scrollTo(el.offset().top, 750, function(el) {
							return function() {
								el.trigger('scroll');
							};
						}(el));
					}
				};

			section = pwf.create('ui.structure.section', opts).load(function(err) {
				v('map-loaded', err);
			});
		}, null, true)

		.on('dispatcher.error', function(pack) {
			v('page-not-found');
		}, null, true);
});
