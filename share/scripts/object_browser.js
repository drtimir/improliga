pwf.rc({
	'name':'object_browser',
	'parents':['container', 'domel'],
	'uses':['list', 'config', 'schema', 'async'],

	'storage':{
		'pager':null,
		'loader':null,
		'opts':{
			'per_page':20,
			'page':0,
			'sort':'created_at'
		}
	},

	'init':function(proto)
	{
		var el = this.get_el();

		el.create_divs(['filters', 'data', 'pager']);

		proto.storage.pager = pwf.create('paginator', {
			'parent':el.pager,
			'per_page':this.get('per_page'),
			'page':this.get('page')
		});

		proto.storage.loader = pwf.list.create({
			'model':proto('model'),
			'url':pwf.config.get('models.url_browse').replace('{model}', proto('model'))
		});
	},

	'public':{
		'load':function(proto)
		{
			var jobs = [
				function(next) {
					pwf.schema.check(proto('model'), next);
				},

				function(next) {
					proto.storage.loader.load(next);
				}
			];

			pwf.async.series(jobs, function(err, response) {
				v(err, response);
			});
		},

		'update_view':function()
		{
		},

		'update_pagi':function(proto)
		{
			var data = loader.get_data();

			proto.storage.pager.update({
				'per_page':this.get('per_column') * cols.length,
				'page':this.get('page'),
				'total':data.total
			});
		}


	}
});
