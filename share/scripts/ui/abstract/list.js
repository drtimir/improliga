pwf.rc('ui.abstract.list', {
	'parents':['domel', 'model.list'],


	'storage':{
		'filter':null,
		'opts':{
			'model':null,
			'draw':null,
			'filters':[],
			'ui_filters':[]
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_ui');
			proto('construct_filters');
			proto('construct_extra');

			proto('update_heading');
			proto('update_footer');
		},


		'construct_ui':function(proto)
		{
			var el = this.get_el().create_divs(['inner', 'header', 'filters', 'content', 'pagi', 'footer'], 'ui-list');

			el.inner
				.append(el.header)
				.append(el.filters)
				.append(el.content)
				.append(el.pagi)
				.append(el.footer);
		},


		'get_filter_elements':function(proto)
		{
			var
				filters = this.get('ui_filters'),
				elements = [];

			for (var i = 0; i < filters.length; i++) {
				var
					filter = filters[i],
					element,
					attr;

				if (typeof filter == 'string') {
					attr = filter;
					element = pwf.form.input_from_attr(this.get('model'), attr, {'required':false});

					if (element['type'] == 'select') {
						element['type'] = 'checkbox';
						element['multiple'] = true;
					}
				}

				elements.push(element);
			}

			return elements;
		},


		'get_filter_data':function(proto) {
			var
				static = this.get('filters'),
				form   = proto.storage.filter.get_data(),
				data;

			if (static !== null) {
				if (typeof static == 'object' && typeof static.length == 'undefined') {
					data = [];
					for (var key in static) {
						data.push({
							'attr':key,
							'type':'exact',
							'exact':static[key]
						});
					}
				} else {
					data = static.slice(0);
				}
			} else {
				data = [];
			}

			for (var key in form) {
				if (form[key]) {
					var input = proto.storage.filter.get_input(key);

					if (input.get('type') == 'text') {
						data.push({
							'attr':key,
							'type':'icontains',
							'icontains':form[key]
						});
					} else {
						data.push({
							'attr':key,
							'type':'exact',
							'exact':form[key]
						});
					}
				}
			}

			v(data);

			return data;
		},


		'construct_filters':function(proto)
		{
			var elements = proto('get_filter_elements');

			proto.storage.filter = pwf.create('form', {
				'parent':this.get_el('filters'),
				'elements':elements,
				'on_change':function(ctrl) {
					return function() {
						ctrl.respond('before_load');
						ctrl.load();
					};
				}(this)
			});
		},


		'update_heading':function(proto)
		{
			this.get_el('header').html(this.get('heading'));
		},


		'loaded':function(proto)
		{
			proto('redraw');
		},


		'redraw':function(proto) {
			var list = this.get_data();

			this.get_el('content').html('');

			for (var i = 0; i < list.data.length; i++) {
				proto('draw_item', list.data[i]);
			}

			this.get_el('content').append(pwf.jquery.span('cleaner'));
		},


		'get_ui_comp':function()
		{
			return this.get('draw');
		},


		'draw_item':function(proto, item)
		{
			var opts = pwf.merge({
				'parent':this.get_el('content'),
				'item':item
			}, item.get_data());


			pwf.create(proto('get_ui_comp', item), opts);
		}
	},


	'public':{

	}
});
