pwf.rc('ui.intra.alert', {
	'parents':['domel'],

	'storage':{
		'opts':{
			'item':null
		}
	},

	'proto':{
		'el_attached':function(proto)
		{
			proto('create_ui');
			proto('fill');
			proto('bind_events');
		},


		'create_ui':function(proto)
		{
			var
				el = this.get_el().create_divs(['text', 'footer', 'footer_data', 'footer_cleaner', 'avatars', 'time', 'author']),
				item = this.get('item');

			if (this.get('team')) {
				el.addClass('team-alert');
				el.avatars.team = pwf.create('ui.link', {
					'cname':'avatar',
					'parent':el.avatars,
					'path':'team',
					'params':{
						'team':this.get('team').get_seoname()
					},
					'propagate':false
				});
			}

			el.avatars.author = pwf.create('ui.link', {
				'cname':'avatar',
				'parent':el.avatars,
				'path':'user',
				'params':{
					'user':this.get('author').get('id')
				},
				'propagate':false
			});

			el.footer_cleaner.addClass('cleaner');

			el.footer
				.append(el.avatars)
				.append(el.footer_data)
				.append(el.footer_cleaner);

			el.footer_data
				.append(el.time)
				.append(el.author);
		},


		'fill':function(proto)
		{
			var
				el = this.get_el(),
				temp = pwf.model.get_attr_opt('Impro::User::Alert', 'template', this.get('template')),
				text = pwf.locales.trans('alert-' + temp.name, this.get_translate_strs());

			el.addClass(this.get('read') ? 'read':'not-read');

			el.text.html(text);
			el.time.html(this.get('created_at').format('D.M. h:mm'));
			el.author.html(pwf.site.get_user_name(this.get('author')));

			pwf.thumb.fit(pwf.site.get_user_avatar(this.get('author')).path, el.avatars.author.get_el());

			if (this.get('team')) {
				pwf.thumb.fit(this.get('team').get('logo').path, el.avatars.team.get_el());
			}
		},


		'bind_events':function(p)
		{
			this.get_el().bind('click', this, p('callbacks').open);
		},


		'callbacks':
		{
			'open':function(e) {
				e.data.open();
			}
		}
	},


	'public':{
		'get_translate_strs':function(p)
		{
			var
				data = {},
				auth = this.get('author'),
				team = this.get('team'),
				tg   = this.get('training');

			if (tg) {
				data.training_name = tg.get('name');
				data.training_start = tg.get('start').format('D.M.YYYY HH:mm');
			}

			if (team) {
				data.team_name = team.get('name');
			}

			if (auth) {
				data.author_name = pwf.site.get_user_name(auth);
			}

			return data;
		},


		'open':function(p)
		{
			var template = pwf.model.get_attr_opt('Impro::User::Alert', 'template', this.get('template'));

			if (template.name == 'invite-training') {
				this.get_el()
					.trigger('deactivate')
					.trigger('navigate', {
						'origin':this,
						'name':'navigate',
						'title':'Trenink',
						'url':pwf.dispatcher.url('team_training', {
							'team':this.get('team').get_seoname(),
							'tg':this.get('training').get('id')
						})
					});
			}
		}
	}
});
