pwf.rc('ui.abstract.menu.ui', {
	'parents':['ui.abstract.menu'],

	'storage':{
		'opts':{
			'items':[],
		}
	},

	'proto':{
		'construct':function(proto)
		{
			var el = this.get_el('menu_content')
				.create_divs(['heading', 'items'], 'create-menu')
				.addClass('typical-menu')
				.bind('activate', this, proto('callbacks').activate);

			proto('construct_heading');
			proto('construct_items');
		},


		'construct_heading':function(proto)
		{
			var el = this.get_el('menu_content').heading
				.addClass('heading')
				.html(pwf.locales.trans(this.get('heading')));
		},


		'construct_items':function(proto)
		{
			var items = this.get('items');

			for (var i = 0, len = items.length; i < len; i++) {
				proto('construct_item', items[i]);
			}
		},


		'construct_item':function(proto, item)
		{
			pwf.create('ui.link', {
				'title':item.title,
				'parent':this.get_el('menu_content').items,
				'cname':'typical-menu-item',
				'event':'activate',
				'ui':item.ui,
				'tag':'div'
			});
		},


		'callbacks':
		{
			'activate':function(e, item)
			{
				e.data.activate(item);
			}
		}
	},


	'public':{
		'load':function(proto, next) {
			return this.respond(next);
		},


		'activate':function(proto, data)
		{
			pwf.create(data.origin.get('ui'), {
				'parent':pwf.jquery('body')
			}).load().show();
		}
	}
});
