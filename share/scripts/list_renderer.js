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
				attrs = this.get('attrs'),
				el = pwf.jquery.div('item');

			var html = pwf.templater.render(this.get('template'), item);
			v(html);

			el.html(html);
			return el;
		}
	}
});
