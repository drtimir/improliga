pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.map([
		{
			'name':'home',
			'anchor':'',
			'build':'ui.home'
		}
	]);


	pwf.queue
		.on('dispatcher.load', function(pack) {
			var
				view = pack.response.view,
				page = view.get('name');

			if (page !== null) {
				var
					el    = pwf.site.get_el(),
					build = view.get('build'),
					jobs  = {};

				pwf.async.parallel(jobs, function(err, items) {
					v(err);
					v(items);
				});
			}
		}, null, true)

		.on('dispatcher.error', function(pack) {
			v('page-not-found');
		}, null, true);
});
