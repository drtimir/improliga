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
				el = this.get_el().create_divs(['image', 'data', 'name', 'info', 'location', 'time']),
				image = this.get('image');

			el.data.append(el.name).append(el.info);
			el.info.append(el.location).append(el.time);

			el.name.html(pwf.jquery('<a/>').html(this.get('name')).attr('href', '/predstaveni/' + this.get('id')));
			el.time.html(proto('format_time'));

			if (this.get('location')) {
				el.location.html(this.get('item').attr_to_html('location'));
			}

			if (!image) {
				image = {
					'url':'<pixmap(logo.png)>'
				};
			}

			image = pwf.thumb.create(image.url, '50x50');
			v(image);
		},


		'format_time':function()
		{
			str = this.get('start').format('D.M.');

			if (this.get('start_time')) {
				var tmp = pwf.moment(this.get('start_time'), 'HH:MM:SS');
				str += tmp.format('H:MM');
			}

			return str;
		}
	}
});
