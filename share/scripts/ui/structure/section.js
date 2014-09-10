pwf.rc('ui.structure.section', {
	'parents':['domel', 'caller', 'ui.abstract.el'],

	'storage':{
		'objects':[],
		'opts':{
			'bind':null,
			'structure':[],
			'vars':{}
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct');
		},


		'construct':function(proto)
		{
			proto('update_classes');
			proto('create_ui');
			proto('create_all');
			proto('bind_events');
		},


		'create_ui':function(proto)
		{
			var name = this.get('bind') ? this.get('bind'):this.get('name');

			this.get_el()
				.create_divs(['inner'], 'section')
				.addClass('section-' + name);
		},


		'create_all':function(proto)
		{
			var items = this.get('structure');

			for (var i = 0, len = items.length; i < len; i++) {
				var
					cname = items[i],
					pass = {};

				if (typeof cname == 'string') {
					scope = pwf.list_scope(cname);
				} else {
					scope = pwf.list_scope(cname.cname);
					pass  = cname.pass;
				}

				for (var j = 0, slen = scope.length; j < slen; j++) {
					proto.storage.objects.push(pwf.create(scope[j], pwf.merge(pass, this.get('vars'), {
						'parent':this.get_el('inner'),
						'vars':this.get('vars')
					})));
				}
			}
		},


		'bind_events':function(p)
		{
			this.get_el()
				.bind('reload', this, p.get('callbacks.reload'));
		},


		'callbacks':
		{
			'reload':function(e, data) {
				var reload = data instanceof Object && typeof data.target == 'string' && e.data.get('name') == data.target;

				if (reload) {
					e.stopPropagation();
					e.data.reload();
				}
			}
		}
	},


	'public':{
		'load':function(proto, next)
		{
			var jobs = [];

			for (var i = 0; i < proto.storage.objects.length; i++) {
				var obj = proto.storage.objects[i];

				if (obj.load instanceof Function) {
					jobs.push(function(obj) {
						return function(next) {
							obj.load(next);
						};
					}(obj));
				}
			}

			pwf.async.parallel(jobs, function(ctrl, proto, next) {
				return function(err) {
					proto('loaded');
					ctrl.respond(next, [err]);
				};
			}(this, proto, next));

			return this;
		},


		'clear':function(proto)
		{
			this.get_el().html('');
			return this;
		},


		'redraw':function(proto, next)
		{
			this.clear().set('item', null);
			proto('construct');
			return this.load(next);
		},


		'reload':function(p, next)
		{
			return this.redraw(next);
		}
	}
});
