pwf.rc('ui.intra.menu', {
	'parents':['domel'],
	'uses':'locales',

	'proto':{
		'items':[
			{
				'ident':'home',
				'title':'menu-homepage'
			},
			{
				'ident':'main',
				'title':'menu-main'
			},
			{
				'ident':'profile',
				'title':'menu-profile'
			},
			{
				'ident':'search',
				'title':'menu-search'
			},
			{
				'ident':'settings',
				'title':'menu-settings'
			},
			{
				'ident':'exit',
				'title':'menu-exit'
			}
		],


		'el_attached':function(proto) {
			proto('construct');
		},


		'construct':function(proto) {
			var
				el    = this.get_el().create_divs(['items']),
				items = proto('items');

			for (var i = 0; i < items.length; i++) {
				proto('create_item', items[i]);
			}
		},


		'create_item':function(proto, item)
		{
			var item = pwf.jquery.div('menu-item menu-' + item.ident)
				.attr('title', pwf.locales.trans_msg(item.title))
				.appendTo(this.get_el('items'));

			return item;
		}
	},


	'public':{
		'resize':function(proto)
		{
			this.get_el('items').css('top', Math.round((this.get_el().height() - this.get_el('items').height())/2));
		}
	}
});
