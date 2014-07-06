pwf.rc('ui.home.header', {
	'parents':['domel', 'ui.abstract.el'],

	'proto':{
		'el_attached':function(proto) {
			proto('update_classed');

			pwf.jquery('header').appendTo(this.get_el());
		}
	}
});
