pwf.rc('ui.intra.sections.home.team_list.member', {
	'parents':['domel'],

	'proto':{
		'el_attached':function(proto)
		{
			proto('construct');
			proto('fill');
			proto('create_actions');
		},


		'construct':function()
		{
			var el = this.get_el()
				.create_divs(['header', 'roles', 'actions'], 'team')
				.create_divs(['cleaner']);

			el.header.create_divs(['logo', 'name'], 'team');
			el.header.name.addClass('heading2');
		},


		'fill':function(proto)
		{
			var
				el     = this.get_el(),
				member = this.get('item'),
				team   = this.get('team');

			el.header.name.html(team.get('name'));

			pwf.thumb.fit(team.get('logo').path, el.header.logo);
			pwf.create('ui.intra.team.member.role.list', {
				'parent':el.roles,
				'roles':member.get('roles')
			});
		},


		'create_actions':function(proto)
		{
			var
				el   = this.get_el('actions'),
				team = this.get('team');

			proto('link', 'team-events', 'team_events');

			if (team.get('use_attendance')) {
				proto('link', 'team-attendance', 'team_trainings');
			}

			if (team.get('use_discussion')) {
				proto('link', 'team-discussion', 'team_discussion');
			}
		},


		'link':function(proto, label, route)
		{
			var
				wrap = pwf.jquery.div('team-action').appendTo(this.get_el('actions')),
				item = pwf.create('ui.link', {
					'parent':wrap,
					'path':route,
					'title':'intra-' + label,
					'params': {
						'team':this.get('team').get_seoname()
					}
				});
		}
	}
});
