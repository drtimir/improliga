pwf.rc('ui.contact.form', {
	'parents':['domel', 'caller'],

	'storage':{
		'form':null
	},


	'proto':{
		'types':[
			{
				'ident':'novice',
				'label':'Chci si vyzkoušet impro'
			},
			{
				'ident':'request',
				'label':'Nabízím hraní'
			},
			{
				'ident':'cili',
				'label':'Chci vstoupit do ČILI'
			},
			{
				'ident':'team',
				'label':'Mám tým, nevím co s ním'
			},
			{
				'ident':'support',
				'label':'Mám problém s webem'
			},
			{
				'ident':'generic',
				'label':'Prostě se chci zeptat'
			}
		],

		'el_attached':function(proto) {
			proto('construct_ui');
			proto('construct_menu');
			proto('construct_form');
		},


		'construct_ui':function(proto) {
			var el = this.get_el().create_divs(['inner', 'menu', 'form']);

			el.inner
				.append(el.menu)
				.append(el.form);

			el.form.hide();
		},


		'construct_menu':function(proto) {
			var
				el = this.get_el('menu').create_divs(['header', 'items', 'footer']),
				types = proto('types');

			pwf.create('ui.abstract.text', {
				'parent':el.header,
				'source':'.contacts-text'
			}).load();

			pwf.create('ui.abstract.text', {
				'parent':el.footer,
				'source':'.contacts-addr'
			}).load();

			for (var i = 0; i < types.length; i++) {
				var type_el = pwf.jquery.div('cf-menu-item cf-menu-' + types[i].ident);

				type_el
					.appendTo(el.items)
					.append(pwf.jquery.span('label').html(types[i].label))
					.bind('click', {'proto':proto, 'type':types[i]}, proto('callbacks').select_type);
			}
		},


		'construct_form':function(proto) {
			proto.storage.form = pwf.create('form', {
				'parent':this.get_el('form'),
				'elements':[
					{
						'name':'email',
						'type':'email',
						'label':'E-Mail'
					},
					{
						'name':'text',
						'type':'textarea',
						'label':'Co nám chcete sdělit?'
					}
				]
			});

		},


		'callbacks':{
			'select_type':function(e) {
			}
		}
	},


	'public':{
		'load':function(proto, next) {
			this.respond(next);
		}
	}
});
