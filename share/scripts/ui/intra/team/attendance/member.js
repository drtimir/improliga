pwf.rc('ui.intra.team.attendance.member', {
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
				user = item.get('user'),
				url  = pwf.dispatcher.url('user', {'user':user.get('id')}),
				link = pwf.jquery('<a/>')
					.attr('href', url)
					.html(pwf.site.get_user_name(user));

			this.get_el().html(link);
		}
	}
});
