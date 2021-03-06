/**
 * Simple element tag that renders color squares for team attendance table.
 */
pwf.rc('ui.intra.team.attendance.ack', {
	'parents':['ui.abstract.el'],

	'storage':{
		'opts':{
			'tag':'td',
			'ack':null,
			'team':null,
			'member':null,
			'user':null
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('draw');
			proto('bind');
		},


		/**
		 * Render basic element status
		 *
		 * @return void
		 */
		'draw':function(proto)
		{
			var
				ack = this.get('ack'),
				tg = this.get('tg'),
				el = this.get_el().create_divs(['inner', 'number'], 'ack');

			el.number.appendTo(el.inner);

			if (ack === null) {
				// No data, no need to worry
				el.inner.addClass('status-unknown');
				el.number.html('?');
			} else {

				// User acknowledged and will come
				if (ack.get('status') == 3) {
					// Fill in count
					el.number.html(ack.get('count'));

				// User has not acknowledged yet
				} else if (ack.get('status') == 2) {
					el.number.html('.');

				// User refused to come
				} else if (ack.get('status') == 4) {
					el.number.html('-');

				// Safeguard
				} else {
					el.number.html('?');
				}

				el.inner.addClass('status-' + ack.get('status'));
			}

			if (tg.get('start').isBefore(pwf.moment(), 'day')) {
				el.inner.addClass('history-tg');
			}
		},


		'redraw':function(proto)
		{
			this.get_el().html('');

			proto('draw');
			proto('bind');
		},


		'bind':function(proto)
		{
			var
				mem  = this.get('member'),
				el   = this.get_el(),
				tg   = this.get('tg'),
				team = this.get('team'),
				before  = tg.get('start').isAfter(pwf.moment(), 'day'),
				own     = pwf.model.cmp(mem.get('user'), pwf.site.get_user()),
				manager = pwf.site.is_user_member_in(team, [2,3]);

			if (manager || (own && before)) {
				el.inner.addClass('writeable');
				el.inner.bind('click', this, proto('callbacks').edit);
			}
		},


		'callbacks':
		{
			'edit':function(e)
			{
				e.data.edit();
			}
		}
	},


	'public':{
		'edit':function(proto)
		{
			var
				ack = this.get('ack'),
				data = {
					'parent':pwf.jquery('body'),
					'after_save':function(ctrl, proto) {
						return function() {
							this.close();

							ctrl.set('ack', this.get('item'));
							proto('redraw');
						};
					}(this, proto)
				};

			if (ack) {
				data.item = ack;
			} else {
				data.item = pwf.model.create('Impro::Team::Training::Ack', {
					'training':this.get('tg'),
					'member':this.get('member'),
					'user':this.get('member').get('user')
				});
			}

			pwf.create('ui.intra.editor.training.ack', data).show().load();
		}
	}
});
