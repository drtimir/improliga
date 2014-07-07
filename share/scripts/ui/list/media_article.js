pwf.rc('ui.list.media_article', {
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
			var el = this.get_el().create_divs(['name', 'publisher', 'date']);
			el.name.html(this.get('name'));
			el.publisher.html(this.get('publisher'));
			el.date.html(this.get('date').format('D.M.YYYY'));
		}
	}
});
