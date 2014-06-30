pwf.rc('ui.event.detail', {
	'parents':['adminer.abstract.object'],

	'storage':{
		'opts':{
			'attrs':[],
			'model':'Impro::Event'
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_backbone');
		},


		'loaded':function(proto)
		{
			proto('construct');
		},


		'construct':function(proto)
		{
			proto('construct_ui');
		},


		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['marginer', 'inner', 'heading', 'labels', 'desc', 'image', 'map']);

			el.marginer.append(el.inner);
			el.inner
				.append(el.heading)
				.append(el.labels)
				.append(el.desc)
				.append(el.image)
				.append(el.map);
		},


		'construct_ui':function(proto)
		{
			var
				el   = this.get_el(),
				item = this.get('item');

			el.heading.html(item.get('name'));
			el.desc.html(item.get('desc_full'));

			if (item.get('image')) {
				el.image.html(pwf.thumb.create(item.get('image')));
			}

			if (item.get('location')) {
				v(item.get('location'));
				el.map.html();
			}
		},
	}
});
