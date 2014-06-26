pwf.rc('ui.list.event', {
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
			var el = this.get_el().create_divs(['name', 'info', 'location', 'time']);
			el.info.append(el.location).append(el.time);

			el.name.html(pwf.jquery('<a/>').html(this.get('name')).attr('href', '/predstaveni/' + this.get('id')));
			el.time.html(proto('format_time'));

			if (this.get('location')) {
				el.location.html(this.get('item').attr_to_html('location'));
			}
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
