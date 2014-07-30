/**
 * Simple element tag that renders color squares for team attendance table.
 */
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


		/**
		 * Render basic element status
		 *
		 * @return void
		 */
		'draw':function(proto)
		{
			var
				ack = this.get('ack'),
				tg = this.get('tg'),
				el = this.get_el().create_divs(['inner', 'number'], 'ack');

			el.number.appendTo(el.inner);

			if (ack === null) {
				// No data, no need to worry
				el.inner.addClass('status-unknown');
				el.number.html('?');
			} else {

				// User acknowledged and will come
				if (ack.get('status') == 3) {
					// Fill in count
					el.number.html(ack.get('count'));

				// User has not acknowledged yet
				} else if (ack.get('status') == 2) {
					el.number.html('.');

				// User refused to come
				} else if (ack.get('status') == 4) {
					el.number.html('-');

				// Safeguard
				} else {
					el.number.html('?');
				}

				el.inner.addClass('status-' + ack.get('status'));
			}

			if (tg !== null) {
				if (tg.get('start').isBefore(pwf.moment(), 'day')) {
					el.inner.addClass('history-tg');
				}
			}
		}
	}
});
