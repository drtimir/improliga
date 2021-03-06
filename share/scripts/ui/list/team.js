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
				el = this.get_el().create_divs(['image', 'data', 'name', 'info', 'city', 'accepting', 'cleaner']),
				item = this.get('item'),
				image = this.get('logo');

			el.data.append(el.name).append(el.info);
			el.info
				.append(el.city)
				.append(el.accepting);

			el.city.html(this.get('city'));

			if (item.get('accepting')) {
				el.accepting.html('Tým nabírá členy');
			} else {
				el.accepting.remove();
			}

			if (!image) {
				image = {
					'path':'logo.png',
					'url':'<pixmap(logo.png)>'
				};
			}

			el.image.html(pwf.thumb.fit(image.path, el.image));
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
