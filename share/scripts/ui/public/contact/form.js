pwf.rc('ui.public.contact.form', {
	'parents':['domel', 'caller', 'ui.abstract.el'],

	'storage':{
		'form':null,
		'opts':{
			'center':true
		}
	},


	'proto':{
		'fade_in':250,
		'fade_out':250,

		'types':[
			{
				'ident':'novice',
				'label':'Chci si vyzkoušet impro'
			},
			{
				'ident':'request',
				'label':'Přijeďte si zahrát'
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
			proto('update_classes');
			proto('construct_ui');
			proto('construct_menu');
			proto('construct_form');
		},


		'construct_ui':function(proto) {
			var el = this.get_el().create_divs(['inner', 'menu', 'form']);

			el.inner
				.append(el.menu)
				.append(el.form);

			el.form
				.hide()
				.addClass('cf-handler');
		},


		'construct_menu':function(proto) {
			var
				el = this.get_el('menu').create_divs(['header', 'items', 'footer']),
				types = proto('types');

			pwf.create('ui.abstract.text', {
				'parent':el.header,
				'source':'.contacts-text',
				'partial':'contacts'
			}).load();

			pwf.create('ui.abstract.text', {
				'parent':el.footer,
				'source':'.contacts-addr',
				'partial':'addr'
			}).load();

			for (var i = 0; i < types.length; i++) {
				var
					type_el = pwf.jquery.div('cf-menu-item cf-menu-' + types[i].ident),
					ctx = {'ctrl':this, 'proto':proto, 'type':types[i]};

				type_el
					.appendTo(el.items)
					.append(pwf.jquery.span('label').html(types[i].label))
					.bind('click', ctx, proto('callbacks').select_type);
			}
		},


		'construct_form':function(proto) {
			proto.storage.form = pwf.create('form', {
				'parent':this.get_el('form'),
				'heading':'Napište nám!',
				'elements':[
					{
						"name":"inputs",
						'type':'inputs',
						'element':'container',
						'elements':[
							{
								'name':'reason',
								'type':'hidden'
							},
							{
								'name':'email',
								'type':'email',
								'label':'E-mail'
							},
							{
								'name':'text',
								'type':'textarea',
								'label':'Zpráva'
							}
						]
					},
					{
						"name":"buttons",
						'type':'buttons',
						'element':'container',
						'elements':[
							{
								'element':'button',
								'name':'text',
								'type':'button',
								'label':'Rozmyslel jsem si to',
								'click':function(ctrl, proto) {
									return function() {
										proto('show_menu');
									}
								}(this, proto)
							},
							{
								'element':'button',
								'name':'text',
								'type':'submit',
								'label':'Odeslat'
							}
						]
					}
				]
			});

			proto.storage.label_placeholder = pwf.jquery.div('placeholder')
				.insertAfter(proto.storage.form.get_el().find('.heading').first())
				.create_divs(['label', 'data']);

			proto.storage.label_placeholder.label.html('Předmět:');
		},


		'show_form':function(proto)
		{
			this.get_el('form').stop(true).fadeIn(proto('fade_in'));
			this.get_el('menu').stop(true).fadeOut(proto('fade_out'), function() {
				pwf.jquery(this).trigger('resize');
			});
		},


		'show_menu':function(proto)
		{
			this.get_el('form').stop(true).fadeOut(proto('fade_out'));
			this.get_el('menu').stop(true).fadeIn(proto('fade_in'), function() {
				pwf.jquery(this).trigger('resize');
			});
		},


		'select_type':function(proto, type)
		{
			proto.storage.form.get_input('reason').val(type.ident);
			proto.storage.label_placeholder.data.html(type.label);
			proto('show_form');
		},


		'callbacks':{
			'select_type':function(e) {
				e.data.proto('select_type', e.data.type);
			}
		}
	},


	'public':{
		'load':function(proto, next) {
			this.respond(next);
		}
	}
});
