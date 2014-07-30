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
				url  = pwf.dispatcher.url('team_training', {
					'team':item.get('team').get_seoname(),
					'tg':item.get('id')
				}),
				link = pwf.jquery('<a/>')
					.attr('href', url)
					.html(item.get('start').format('D.M.'));


			if (item.get('start').isBefore(pwf.moment(), 'day')) {
				el.addClass('history-tg');
			}

			el.html(link);
		}
	}
});
