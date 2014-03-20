pwf.rc({
	'name':'object_browser',
	'parents':['container', 'domel'],
	'uses':['list', 'config', 'schema', 'async', 'form'],

	'storage':{
		'pager':null,
		'loader':null,
		'opts':{
			'per_page':20,
			'page':0,
			'sort':'created_at',
			'on_error':function(ctrl, ocurrence, msg) {
				v(msg);
			}
		}
	},

	'init':function(proto)
	{
		var el = this.get_el();

		el.create_divs(['filters', 'data', 'pager']);

		//~ proto.storage.filter = pwf.form.create({
		//~ });

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

			pwf.async.series(jobs, function(ctrl) {
				return function(err, response) {
					if (err === null)  {
						ctrl.update_view();
					} else ctrl.get('on_error')(ctrl, 'loading', err);
				};
			}(this));
		},

		'update_view':function(proto)
		{
			var data = proto.storage.loader.get_data();

			return this.update_pagi();
		},

		'update_pagi':function(proto)
		{
			var data = proto.storage.loader.get_data();

			proto.storage.pager.update({
				'per_page':this.get('per_page'),
				'page':this.get('page'),
				'total':data.total
			});
		}


	}
});
