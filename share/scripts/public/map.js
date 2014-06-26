pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.map([
		{
			'name':'home',
			'anchor':'',
			'bind':'ui-home'
		},
		{
			'name':'about',
			'anchor':'o-improlize',
			'bind':'ui-about',
		},
		{
			'name':'shows',
			'anchor':'predstaveni',
			'bind':'ui-shows',
		},
		{
			'name':'teams',
			'anchor':'tymy',
			'bind':'ui-teams',
		},
		{
			'name':'workshops',
			'anchor':'workshopy',
			'bind':'ui-workshops',
		},
		{
			'name':'contacts',
			'anchor':'kontakty',
			'bind':'ui-contact',
		}
	]);


	pwf.queue
		.on('dispatcher.load', function(pack) {
			var
				view = pack.response.view,
				page = view.get('name');

			if (page !== null) {
				var
					el    = pwf.jquery('.section.' + view.get('bind')),
					build = view.get('build');

				if (el.length) {
					pwf.jquery('html,body').stop(true).scrollTo(el.offset().top, 750, function() {
						pwf.jquery('#viewport').trigger('update_menu');
					});
				}
			}
		}, null, true)

		.on('dispatcher.error', function(pack) {
			v('page-not-found');
		}, null, true);
});
