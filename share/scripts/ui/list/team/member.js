pwf.rc('ui.list.team.member', {
	'parents':['domel'],

	'proto':{
		'el_attached':function(proto) {
			proto('construct');
			proto('fill');
		},

		'construct':function(proto) {
			var el = this.get_el().create_divs(['avatar', 'data', 'name', 'roles', 'cleaner'], 'member');

			el.data
				.append(el.name)
				.append(el.roles);

			el.cleaner.addClass('cleaner');
		},


		'fill':function(proto)
		{
			var
				el = this.get_el(),
				item = this.get('item'),
				user = item.get('user'),
				avatar = user.get('avatar');

			el.name.html(pwf.site.get_user_name(user));
			pwf.thumb.fit(avatar.path, el.avatar);

			pwf.create('ui.intra.team.member.role.list', {
				'parent':el.roles,
				'roles':item.get('roles')
			});
		}
	}
});
