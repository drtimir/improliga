pwf.rc('ui.list.team', {
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
				el = this.get_el().create_divs(['image', 'data', 'name', 'info', 'city', 'time', 'cleaner']),
				image = this.get('image');

			el.data.append(el.name).append(el.info);
			el.info.append(el.city).append(el.time);

			el.city.html(this.get('city'));

			if (!image) {
				image = {
					'name':'logo.png',
					'url':'<pixmap(logo.png)>'
				};
			}

			el.image.html(pwf.thumb.create(image.name, el.image.width() + 'x' + el.image.height()));
			el.name.html(pwf.jquery('<a/>').html(this.get('name')).attr('href', this.get_url()));
			this.get_el().bind('click', this, proto('callbacks').navigate);
		},


		'callbacks':{
			'navigate':function(e) {
				document.location = e.data.get_url();
			}
		}
	},


	'public':{
		'get_url':function() {
			return '/tymy/' + this.get('item').get_seoname();
		}
	}
});
