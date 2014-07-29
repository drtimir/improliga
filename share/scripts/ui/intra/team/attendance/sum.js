pwf.rc('ui.intra.team.attendance.sum', {
	'parents':['ui.abstract.el'],

	'storage':{
		'opts':{
			'tag':'th'
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
				item = this.get('item'),
				acks = this.get('acks'),
				sum = 0,
				el = this.get_el();

			for (var i = 0, len = acks.length; i < len; i++) {
				var ack = acks[i];

				if (ack.get('status') == 3) {
					sum += ack.get('count');
				}
			}

			if (sum <= 4) {
				el.addClass('status-not-enough');
			}

			el.html(sum);
		}
	}
});
