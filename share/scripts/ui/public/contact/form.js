pwf.rc('ui.contact.form', {
	'parents':['domel', 'caller'],

	'storage':{
		'form':null
	},


	'proto':{
		'types':[
			{
				'ident':'generic',
				'label':'Prostě se chci zeptat'
			},
			{
				'ident':'team',
				'label':'Chci si vyzkoušet impro'
			},
			{
				'ident':'request',
				'label':'Nabízím hraní'
			},
			{
				'ident':'team',
				'label':'Mám problém s webem'
			}
		],

		'el_attached':function(proto) {
			proto('construct_ui');
			proto('construct_form');
		},


		'construct_ui':function(proto) {
			var
				el = this.get_el().create_divs(['inner', 'menu', 'form']),
				types = proto('types');

			el.inner
				.append(el.menu)
				.append(el.form);

			for (var i = 0; i < types.length; i++) {
				var type_el = pwf.jquery.div('cf-menu-item cf-menu-' + types[i].ident);

				type_el
					.appendTo(el.menu)
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
