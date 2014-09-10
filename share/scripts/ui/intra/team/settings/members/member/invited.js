pwf.rc('ui.intra.team.settings.members.member.invited', {
	'parents':['domel'],

	'proto':{
		'el_attached':function(proto) {
			proto('create_ui');
			proto('fill');
		},


		'fill':function(proto)
		{
			var
				el = this.get_el('data'),
				item = this.get('item');

			el.html(this.get('rcpt'));
		},


		'create_ui':function(proto)
		{
			var el = this.get_el().create_divs(['data', 'ui', 'edit', 'drop'], 'member');

			el.ui
				.append(el.edit)
				.append(el.drop)
				.prependTo(el)
				.hide();

			el.drop
				.addClass('button')
				.html(pwf.locales.trans('team-member-invite-cancel'))
				.bind('click', this, proto('callbacks').open_kicker);

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

			'open_kicker':function(e) {
				e.data.open_kicker();
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


		'open_kicker':function(proto)
		{
			pwf.create('ui.intra.team.settings.members.invitations.kicker', {
				'item':this.get('item'),
				'parent':pwf.jquery('body'),
				'reload':{
					'el':this.get_el()
				},
				'after_save':function(ctrl) {
					return function() {
						ctrl.get('ref').load();
						this.close();
					};
				}(this)
			}).load().show();
		},
	}
});
