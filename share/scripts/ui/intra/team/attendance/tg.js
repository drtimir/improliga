pwf.rc('ui.intra.team.attendance.tg', {
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
				el   = this.get_el(),
				item = this.get('item'),
				link = pwf.create('ui.link', {
					'parent':el,
					'path':'team_training',
					'title':item.get('start').format('D.M.'),
					'params':{
						'team':item.get('team').get_seoname(),
						'tg':item.get('id')
					}
				});

			if (item.get('start').isBefore(pwf.moment(), 'day')) {
				el.addClass('history-tg');
			}
		}
	}
});
