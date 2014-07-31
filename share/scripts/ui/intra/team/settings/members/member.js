pwf.rc('ui.intra.team.settings.members.member', {
	'parents':['ui.list.team.member'],

	'proto':{
		'el_attached':function(proto)
		{
			proto('create_structure');
			proto('create_ui');
			proto('fill');
		},


		'create_ui':function(proto)
		{
			var el = this.get_el().create_divs(['ui', 'edit', 'drop'], 'member');

			el.ui
				.append(el.edit)
				.append(el.drop)
				.prependTo(el)
				.hide();

			el.edit
				.addClass('button')
				.html(pwf.locales.trans('team-member-edit'))
				.bind('click', this, proto('callbacks').open_editor);

			el.drop
				.addClass('button')
				.html(pwf.locales.trans('team-member-drop'))
				.bind('click', this, proto('callbacks').open_dropman);

			el.bind('mouseenter', this, proto('callbacks').ui_show);
			el.bind('mouseleave', this, proto('callbacks').ui_hide);
		},


		'callbacks':
		{
			'ui_show':function(e) {
				e.data.ui_show();
			},

			'ui_hide':function(e) {
				e.data.ui_hide();
			},

			'open_editor':function(e) {
				e.data.open_editor();
			},

			'open_dropman':function(e) {
				e.data.open_dropman();
			},
		}
	},


	'public':{
		'ui_show':function(proto)
		{
			this.get_el('ui').stop(true).fadeIn(200);
		},


		'ui_hide':function(proto)
		{
			this.get_el('ui').stop(true).fadeOut(200);
		},


		'open_editor':function(proto)
		{
			pwf.create('ui.intra.team.settings.members.member.editor', {
				'item':this.get('item'),
				'parent':pwf.jquery('body')
			}).load().show();
		},


		'open_dropman':function(proto)
		{
		},
	}
});
