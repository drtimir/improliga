pwf.rc('ui.intra.team.attendance.ack', {
	'parents':['ui.abstract.el'],

	'storage':{
		'opts':{
			'tag':'td'
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('draw');
		},


		'draw':function(proto)
		{
			var
				ack = this.get('ack'),
				el = this.get_el().create_divs(['inner', 'number'], 'ack');

			el.number.appendTo(el.inner);

			if (ack === null) {
				el.inner.addClass('status-unknown');
				el.number.html('?');
			} else {
				if (ack.get('status') == 3) {
					el.number.html(ack.get('count'));
				} else if (ack.get('status') == 2) {
					el.number.html('.');
				} else if (ack.get('status') == 4) {
					el.number.html('-');
				} else {
					el.number.html('?');
				}

				el.inner.addClass('status-' + ack.get('status'));
			}
		}
	}
});
