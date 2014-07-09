pwf.rc('ui.intra.menu', {
	'parents':['domel'],
	'uses':'locales',

	'proto':{
		'items':[
			{
				'ident':'home',
				'title':'menu-homepage',
				'href':'/'
			},
			{
				'ident':'main',
				'title':'menu-main',
				'fire':'ui.intra.menu.main'
			},
			{
				'ident':'profile',
				'title':'menu-profile',
				'fire':'ui.intra.menu.profile'
			},
			{
				'ident':'create',
				'title':'menu-create',
				'fire':'ui.intra.menu.create'
			},
			{
				'ident':'search',
				'title':'menu-search',
				'fire':'ui.intra.menu.search'
			},
			{
				'ident':'settings',
				'title':'menu-settings',
				'fire':'ui.intra.menu.settings'
			},
			{
				'ident':'exit',
				'title':'menu-exit',
				'href':'/logout'
			}
		],


		'el_attached':function(proto) {
			proto('construct');
		},


		'construct':function(proto) {
			var
				el    = this.get_el().create_divs(['inner', 'items'], 'menu'),
				items = proto('items');


			el.inner.append(el.items);
			el.bind('deactivate', {'proto':proto}, proto('callbacks').deactivate);

			for (var i = 0; i < items.length; i++) {
				proto('create_item', items[i]);
			}

			this.resize();
		},


		'create_item':function(proto, item)
		{
			var item = pwf.jquery.div('menu-item menu-' + item.ident)
				.attr('title', pwf.locales.trans_msg(item.title))
				.bind('click', {'item':item, 'ctrl':this, 'proto':proto}, proto('callbacks').activate)
				.appendTo(this.get_el('items'));

			return item;
		},


		'activate':function(proto, item)
		{
			if ('fire' in item) {
				proto('deactivate');
				proto.storage.active = pwf.create(item.fire, {
					'parent':this.get_el()
				});

				proto.storage.active.show().load();
			}

			if ('href' in item) {
				document.location = item.href;
			}
		},


		'deactivate':function(proto)
		{
			if (proto.storage.active) {
				proto.storage.active.hide();
				proto.storage.active = null;
			}
		},


		'callbacks':{
			'activate':function(e) {
				e.preventDefault();
				e.data.proto('activate', e.data.item);
			},

			'deactivate':function(e) {
				e.preventDefault();
				e.data.proto('deactivate');
			}
		}
	},


	'public':{
		'resize':function(proto)
		{
			this.get_el('items').css('top', Math.round((this.get_el('inner').height() - this.get_el('items').height())/2));
		}
	}
});
