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
			var el = this.get_el().create_divs(['name', 'info', 'location', 'time']);
			el.info.append(el.location).append(el.time);

			el.name.html(pwf.jquery('<a/>').html(this.get('name')).attr('href', '/predstaveni/' + this.get('id')));
		}
	}
});
