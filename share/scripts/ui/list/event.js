pwf.rc('ui.list.event', {
	'parents':['domel'],
	'uses':['thumb'],

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
				el = this.get_el().create_divs(['image', 'data', 'name', 'info', 'location', 'time', 'cleaner']),
				image = this.get('image');

			el.data.append(el.name).append(el.info);
			el.info.append(el.location).append(el.time);

			el.name.html(pwf.jquery('<a/>').html(this.get_name()).attr('href', this.get_url()));
			el.time.html(proto('format_time'));

			if (this.get('location')) {
				el.location.html(this.get('item').attr_to_html('location'));
			}

			if (!image) {
				image = {
					'name':'logo.png',
					'url':'<pixmap(logo.png)>'
				};
			}

			el.image.html(pwf.thumb.create(image.name, el.image.width() + 'x' + el.image.height()));
			this.get_el().bind('click', this, proto('callbacks').navigate);
		},


		'format_time':function()
		{
			str = this.get('start').format('D.M.');

			if (this.get('start_time')) {
				var tmp = pwf.moment(this.get('start_time'), 'HH:MM:SS');
				str += tmp.format('H:MM');
			}

			return str;
		},


		'callbacks':{
			'navigate':function(e) {
				pwf.site.navigate(e.data.get_url());
			}
		}
	},

	'public':{
		'get_url':function()
		{
			return '/predstaveni/' + this.get('item').get_seoname();
		},


		'get_name':function()
		{
			var name = this.get('name');

			if (name.length > 54) {
				name = name.substr(0, 54) + ' ..';
			}

			return name;
		}
	}
});
