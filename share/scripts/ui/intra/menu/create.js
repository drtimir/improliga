pwf.rc('ui.intra.menu.create', {
	'parents':['ui.abstract.menu'],

	'proto':{
		'items':[
			{
				'name':'menu-create-show',
				'ui':'ui.intra.editor.show'
			},
			{
				'name':'menu-create-workshop',
				'ui':'ui.intra.editor.workshop'
			},
			{
				'name':'menu-create-training',
				'ui':'ui.intra.editor.training'
			}
		],


		'construct':function(proto)
		{
			var el = this.get_el('menu_content')
				.create_divs(['items'], 'create-menu')
				.addClass('typical-menu')
				.bind('activate', this, proto('callbacks').activate);

			el.cleaner.addClass('cleaner');
			el.editor.bind('click', function(e) {
				e.stopPropagation();
			});
			proto('construct_items');
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
			pwf.create('ui.intra.menu.create.item', pwf.merge(item, {
				'parent':this.get_el('menu_content').items
			}));
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


		'activate':function(proto, item)
		{
			var el = this.get_el('menu_content')

			el.editor.html('');

			pwf.create(item.get('ui'), {
				'parent':pwf.jquery('body')
			}).load().show();
		}
	}
});
