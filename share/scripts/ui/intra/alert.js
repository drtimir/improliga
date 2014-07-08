pwf.rc('ui.intra.alert', {
	'parents':['domel'],

	'storage':{
		'opts':{
			'item':null
		}
	},

	'proto':{
		'el_attached':function(proto) {
			proto('construct');
		},


		'construct':function(proto) {
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


		'fill':function(proto) {
			var el = this.get_el();

			el.text.html(this.get('text'));
			el.time.html(this.get('created_at').format('D.M. h:mm'));
			el.author.html(pwf.site.get_user_name(this.get('author')));

			pwf.thumb.fit(pwf.site.get_user_avatar(this.get('author')).path, el.avatar);
		},
	}
});
