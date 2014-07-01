pwf.rc('ui.team.detail', {
	'parents':['ui.abstract.detail'],

	'storage':{
		'opts':{
			'attrs':[],
			'model':'Impro::Team'
		}
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['marginer', 'inner', 'left', 'right', 'logo', 'heading', 'name_full', 'dissolved', 'labels', 'desc', 'image', 'map', 'cleaner'], 'team-detail');

			el.heading.addClass('heading');

			el.marginer.append(el.inner);
			el.inner
				.append(el.left)
				.append(el.right)
				.append(el.cleaner);

			el.left
				.append(el.heading)
				.append(el.name_full)
				.append(el.dissolved)
				.append(el.labels)
				.append(el.desc_short)
				.append(el.desc);

			el.right
				.append(el.image)
				.append(el.map);
		},


		'construct_ui':function(proto)
		{
			var
				el   = this.get_el(),
				item = this.get('item');

			el.heading.html(item.get('name'));

			if (item.get('name') != item.get('name_full') && item.get('name_full')) {
				el.name_full.html(item.get('name_full'));
			} else {
				el.name_full.remove();
			}

			if (item.get('dissolved')) {
				el.dissolved.html(pwf.locales.trans('team-dissolved'));
			}

			if (item.get('city')) {
				proto('create_label', 'city', item.get('city'));
			}

			if (item.get('site')) {
				proto('create_label', 'site', item.get('site'));
			}

			if (item.get('accepting')) {
				proto('create_label', 'accepting');
			}

			el.desc.html(item.get('about'));
			el.desc.html(el.desc.text());


			if (item.get('photo')) {
				el.image.html(pwf.thumb.create(item.get('photo').path, el.image.width() + 'x' + el.image.height()));
			}
		}
	}
});
