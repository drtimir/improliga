pwf.rc('ui.public.home.header', {
	'parents':['domel'],

	'storage':{
		'opts':{
			'tag':'header',
			'items':[
				{'title':'public-menu-home', 'cname':'menu-home', 'path':'home'},
				{'title':'public-menu-about', 'cname':'menu-about', 'path':'home', 'params':{'section':'o-improlize'}},
				{'title':'public-menu-shows', 'cname':'menu-shows', 'path':'home', 'params':{'section':'predstaveni'}},
				{'title':'public-menu-teams', 'cname':'menu-teams', 'path':'home', 'params':{'section':'tymy'}},
				{'title':'public-menu-workshops', 'cname':'menu-workshops', 'path':'home', 'params':{'section':'workshopy'}},
				{'title':'public-menu-media', 'cname':'menu-media', 'path':'home', 'params':{'section':'media-o-improlize'}},
				{'title':'public-menu-contact', 'cname':'menu-contact', 'path':'home', 'params':{'section':'kontakty'}}
			]
		}
	},

	'proto':{
		'el_attached':function(proto)
		{
			proto('construct');
			proto('construct_items');
			proto('update_classes');
		},


		'construct':function(proto)
		{
			var el = this.get_el().create_divs(['inner', 'icon', 'menu'], 'site');

			el.inner
				.append(el.icon)
				.append(el.menu);

			pwf.create('ui.link', {
				'parent':el.icon,
				'cname':'logo',
				'path':'home',
				'params':{'section':''}
			});

			el.icon.create_divs(['name'], 'site');
			el.icon.name.create_divs(['name', 'desc']);

			el.icon.name.name.html(pwf.locales.trans('impro_name'));
			el.icon.name.desc.html(pwf.locales.trans('impro_name_desc'));

			el.menu.create_divs(['center', 'inner'], 'main-menu');
			el.menu.center.append(el.menu.inner);
		},


		'construct_items':function(proto)
		{
			var
				items = this.get('items'),
				el = this.get_el('menu');

			for (var i = 0; i < items.length; i++) {
				pwf.create('ui.link', pwf.merge(items[i], {
					'parent':el.inner,
				}));
			}
		}
	}
});
