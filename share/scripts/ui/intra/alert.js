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
			proto('construct');
		},


		'construct':function(proto)
		{
			var
				el = this.get_el().create_divs(['text', 'footer', 'footer_data', 'footer_cleaner', 'avatar', 'time', 'author']),
				item = this.get('item');

			el.footer_cleaner.addClass('cleaner');

			el.footer
				.append(el.avatar)
				.append(el.footer_data)
				.append(el.footer_cleaner);

			el.footer_data
				.append(el.time)
				.append(el.author);

			proto('fill');
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

			pwf.thumb.fit(pwf.site.get_user_avatar(this.get('author')).path, el.avatar);
		},
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
		}
	}
});
