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
			proto('construct_ui');
			proto('construct_all');
		},


		'construct_ui':function(proto)
		{
			var name = this.get('bind') ? this.get('bind'):this.get('name');

			this.get_el()
				.create_divs(['inner'], 'section')
				.addClass('section-' + name);
		},


		'construct_all':function(proto)
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


		'redraw':function(proto, next)
		{
			proto('loaded');
			this.respond(next);
			return this;
		}
	}
});
