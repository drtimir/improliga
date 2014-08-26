pwf.rc('ui.intra.menu.create', {
	'parents':['ui.abstract.menu'],

	'proto':{
		'items':[
			{
				'title':'menu-create-event',
				'ui':'ui.intra.editor.event'
			},
			{
				'title':'menu-create-training',
				'ui':'ui.intra.editor.training'
			}
		],


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
				.html(pwf.locales.trans('menu-create'));
		},


		'construct_items':function(proto)
		{
			var items = proto('items');

			for (var i = 0, len = items.length; i < len; i++) {
				proto('construct_item', items[i]);
			}
		},


		'construct_item':function(proto, item)
		{
			pwf.create('ui.abstract.el.link', {
				'title':pwf.locales.trans(item.title),
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
