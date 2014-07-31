pwf.rc('ui.intra.team.attendance.ctrl', {
	'parents':['ui.abstract.el'],

	'storage':{
		'opts':{
			'tag':'th',
			'dir':1
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			var el = this.get_el();

			el
				.attr('title', pwf.locales.trans_msg('attd-' + this.get('name')))
				.bind('click', this, proto('callbacks').move);
		},


		'callbacks':{
			'move':function(e)
			{
				e.stopPropagation();
				e.preventDefault();

				e.data.get_el().trigger('attd-move', {
					'dir':e.data.get('dir')
				});
			}
		}
	}
});
