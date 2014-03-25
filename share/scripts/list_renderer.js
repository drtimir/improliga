pwf.rc({
	'name':'list_renderer',
	'parents':['container'],
	'uses':['jquery', 'model', 'icanhaz'],

	'storage':{
		'opts':{
			'template':null
		}
	},

	'init':function(proto)
	{
	},

	'public':{

		'render':function(proto, data, parent)
		{
			for (var i = 0; i < data.length; i++) {
				var item = this.render_item(data[i]);
				parent.append(item);
			}

			return this;
		},

		'render_item':function(proto, item)
		{
			var
				el = pwf.jquery.div('item'),
				data = {},
				attrs = item.model().get_attrs();

			for (var i = 0; i < attrs.length; i++) {
				data[attrs[i].name] = item.get(attrs[i].name);
			}

			data.item = item;

			el.html(pwf.templater.render(this.get('template'), data));
			return el;
		}
	}
});
