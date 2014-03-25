pwf.rc({
	'name':'list_browser',
	'parents':['container', 'domel'],
	'uses':['list', 'config', 'schema', 'async', 'form'],

	'storage':{
		'pager':null,
		'loader':null,
		'filter':null,
		'renderer':null,

		'opts':{
			'per_page':20,
			'page':0,
			'sort':['created_at desc'],

			'filters':[],
			'static_filters':[],

			'after_load':null,
			'after_render':null,

			'before_load':null,
			'before_render':null,

			'on_error':function(ctrl, ocurrence, msg) {
				v(msg);
			}
		}
	},

	'init':function(proto)
	{
		var
			el = this.get_el(),
			filter_update = function(ctrl) {
				return function(form) {
					v('change');
					ctrl.load();
				};
			}(this);

		el.create_divs(['filters', 'data', 'pager']);

		proto.storage.filter = pwf.form.create({
			'parent':el.filters,
			'on_send':filter_update,
			'on_change':filter_update,
			'elements':this.get_filter_inputs()
		});

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
					pwf.templater.load_all(next);
				},

				function(next) {
					pwf.schema.check(proto('model'), next);
				},

				function(next) {
					proto.storage.loader.load(next);
				}
			];

			this.get_el().addClass('loading');
			proto.storage.loader.update({
				'per_page':this.get('per_page'),
				'page':this.get('page'),
				'sort':this.get('sort'),
				'filters':this.get_filter_data()
			});

			if (typeof this.get('before_load') == 'function') {
				this.get('before_load')(this);
			}

			pwf.async.series(jobs, function(ctrl) {
				return function(err, response) {
					if (err === null)  {

						if (typeof ctrl.get('after_load') == 'function') {
							ctrl.get('after_load')(this);
						}

						ctrl.update_view();
					} else ctrl.get('on_error')(ctrl, 'loading', err);
				};
			}(this));
		},

		'update_view':function(proto)
		{
			var list = proto.storage.loader.get_data();

			if (typeof this.get('before_render') == 'function') {
				this.get('before_render')(this);
			}

			this.get_el().data.html('');

			if (typeof proto.storage.renderer == 'object' && proto.storage.renderer !== null) {
				proto.storage.renderer.render(list.data, this.get_el().data);
			}

			this.update_pagi();
			this.get_el().removeClass('loading');

			if (typeof this.get('after_render') == 'function') {
				this.get('after_render')(this);
			}

			return this;
		},

		'update_pagi':function(proto)
		{
			var data = proto.storage.loader.get_data();

			proto.storage.pager.update({
				'per_page':this.get('per_page'),
				'page':this.get('page'),
				'total':data.total
			});
		},

		'get_filter_data':function(proto)
		{
			return pwf.jquery.extend(proto.storage.filter.get_data(), this.get('static_filters'));
		},

		'get_filter_inputs':function(proto)
		{
			return this.get('filters');
		}
	}
});
