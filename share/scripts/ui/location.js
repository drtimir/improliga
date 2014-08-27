pwf.rc('ui.location', {
	'parents':['domel'],

	'storage':{
		'opts':{
			'map':true
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
				el = this.get_el(),
				list = ['name', 'addr'];

			if (this.get('site')) {
				list.push('site');
			}

			if (this.get('map')) {
				list.push('map');
			}

			el.create_divs(list);
			el.name.html(this.get('name'));
			el.addr.html(this.get('addr'));

			if (this.get('site')) {
				el.site.html(pwf.jquery('<a/>').attr('href', this.get('site')).html(this.get('site')));
			}

			if (this.get('map')) {
				pwf.create('ui.link', {
					'parent':el.map,
					'title':'detail-location-show-on-map',
					'url':'https://www.google.cz/maps/place/' + this.get('addr')
				});
			}

		}
	}
});
