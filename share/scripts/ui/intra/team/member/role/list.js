pwf.rc('ui.intra.team.member.role.list', {
	'parents':['domel'],

	'proto':{
		'el_attached':function(proto)
		{
			proto('redraw');
		},


		'redraw':function(proto)
		{
			var roles = this.get('roles');

			for (var i = 0, len = roles.length; i < len; i++) {
				proto('draw_item', roles[i]);
			}
		},


		'draw_item':function(proto, role_id)
		{
			var
				el   = pwf.jquery.div('role role-' + role_id),
				role = pwf.config.get('team.member.roles.' + role_id);

			el.html(pwf.locales.trans(role.name));

			this.get_el().append(el);
		}
	}

});
