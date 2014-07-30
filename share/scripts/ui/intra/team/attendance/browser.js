pwf.rc('ui.intra.team.attendance.browser', {
	'parents':['ui.abstract.el.async', 'adminer.abstract.filters'],


	'storage':{
		'members':null,
		'trainings':[],
		'acks':[],

		'opts':{
			'month':null,
			'team':null,
			'ui_filters':[
				{
					'type':'month',
					'name':'start',
					'label':'attd-since'
				},
				{
					'type':'month',
					'name':'end',
					'label':'attd-until'
				}
			]
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			// Reset month if not available
			if (!this.get('month')) {
				this.set('month', pwf.moment());
			}

			// Reset month range
			proto.storage.opts.ui_filters[0].value = this.get('month').clone().add('months', -1).format('YYYY-MM');
			proto.storage.opts.ui_filters[1].value = this.get('month').clone().add('months', 1).format('YYYY-MM');

			// Render basic structure
			proto('create_structure');
			proto('create_controls');
			proto('create_filters');
			proto('draw_heading');
		},


		/**
		 * Create basic elements
		 *
		 * @return void
		 */
		'create_structure':function(proto)
		{
			var el = this.get_el().create_divs(['inner', 'heading', 'filter', 'controls', 'empty', 'content'], 'attd');

			el.empty.hide();
			el.table = pwf.jquery('<table cellspacing="0" cellpadding="0"/>').appendTo(el.content);

			el.table.head = pwf.jquery('<thead/>').appendTo(el.table);
			el.table.body = pwf.jquery('<tbody/>').appendTo(el.table);
			el.table.foot = pwf.jquery('<tfoot/>').appendTo(el.table);
		},


		/**
		 * Draw arrows that move range of attendance table
		 *
		 * @return void
		 */
		'create_controls':function(proto)
		{
			var el = this.get_el();

			el.bind('attd-move', this, proto('callbacks').move);

			pwf.create('ui.intra.team.attendance.ctrl', {
				'name':'prev',
				'parent':el.controls,
				'dir':-1
			});

			pwf.create('ui.intra.team.attendance.ctrl', {
				'name':'next',
				'parent':el.controls,
				'dir':1
			});
		},


		/**
		 * Draw static heading
		 *
		 * @return void
		 */
		'draw_heading':function()
		{
			this.get_el('heading')
				.html(pwf.locales.trans('attd-heading'))
				.addClass('heading');
		},


		/**
		 * Load members for selected teams. This query runs only once
		 *
		 * @param function next
		 * @return void
		 */
		'load_members':function(proto, next)
		{
			if (proto.storage.members === null) {
				var list = pwf.create('model.list', {
					'model':'Impro::Team::Member',
					'join':['user'],
					'per_page':1024,
					'filters':[
						{
							'attr':'id_impro_team',
							'type':'exact',
							'exact':this.get('team')
						}
					]
				});

				list.load(function(ctrl) {
					return function(err, response) {
						proto.storage.members = response.data;
						ctrl.respond(next, [err]);
					};
				}(this));
			} else {
				this.respond(next);
			}
		},


		/**
		 * Load training instances for selected team and timespan
		 *
		 * @param function next
		 * @return void
		 */
		'load_trainings':function(proto, next)
		{
			var
				start = proto.storage.filter.get_input('start').val(),
				end   = proto.storage.filter.get_input('end').val(),
				list = pwf.create('model.list', {
					'model':'Impro::Team::Training',
					'sort':[{'attr':'start'}],
					'per_page':1024,
					'filters':[
						{
							'attr':'id_team',
							'type':'exact',
							'exact':this.get('team')
						},
						{
							'attr':'start',
							'type':'gte',
							'gte':start.startOf('month').format('YYYY-MM-DD')
						},
						{
							'attr':'start',
							'type':'lte',
							'lte':end.endOf('month').format('YYYY-MM-DD')
						}
					]
				});

			list.load(function(ctrl) {
				return function(err, response) {
					proto.storage.trainings = response.data;
					ctrl.respond(next, err);
				};
			}(this));
		},


		/**
		 * Load responses of selected users to selected trainings
		 *
		 * @param function next
		 * @return void
		 */
		'load_acks':function(proto, next)
		{
			var
				list_tg = this.get_tg_ids(),
				list_member = this.get_member_ids();

			if (list_tg.length && list_member.length) {
				var list = pwf.create('model.list', {
					'model':'Impro::Team::Training::Ack',
					'per_page':8152,
					'filters':[
						{
							'attr':'id_training',
							'type':'in',
							'in':list_tg
						},
						{
							'attr':'id_member',
							'type':'in',
							'in':list_member
						}
					]
				});

				list.load(function(ctrl) {
					return function(err, response) {
						proto.storage.acks = response.data;
						ctrl.respond(next, err);
					};
				}(this));
			} else {
				proto.storage.acks = [];
				this.respond(next);
			}
		},


		/**
		 * Internal callback after loaded. Draws table with data
		 *
		 @return void
		 */
		'loaded':function(proto)
		{
			this.loader_hide();
			proto('draw_table');
		},


		/**
		 * Draw whole table and fill it with data
		 *
		 * @return void
		 */
		'draw_table':function(proto)
		{
			var el = this.get_el('table');

			el.stop(true).show();
			this.get_el('empty').stop(true).hide();

			el.head.html('');
			el.body.html('');
			el.foot.html('');

			if (proto.storage.trainings.length) {
				proto('draw_table_head');
				proto('draw_table_body');
				proto('draw_table_foot');
			} else {
				proto('draw_no_data');
			}
		},


		/**
		 * Draw table head and fill it with training dates
		 *
		 * @return void
		 */
		'draw_table_head':function(proto)
		{
			var
				el = this.get_el('table'),
				trainings = proto.storage.trainings;

			el.head.html('');
			el.head.row = pwf.jquery('<tr/>').appendTo(el.head);

			pwf.jquery('<th/>').appendTo(el.head.row);

			for (var i = 0, len = trainings.length; i < len; i++) {
				pwf.create('ui.intra.team.attendance.tg', {
					'item':trainings[i],
					'parent':el.head.row
				});
			}
		},


		/**
		 * Draw table body and fill it with user responses to training invites
		 *
		 * @return void
		 */
		'draw_table_body':function(proto)
		{
			var
				el = this.get_el('table'),
				members = proto.storage.members.sort(proto('callbacks').sort_members),
				trainings = proto.storage.trainings;

			for (var m = 0, mlen = members.length; m < mlen; m++) {
				var row = pwf.jquery('<tr/>')
					.appendTo(el.body)
					.addClass(m%2 ? 'odd':'even');

				pwf.create('ui.intra.team.attendance.member', {
					'item':members[m],
					'parent':row,
				});

				for (var t = 0, tlen = trainings.length; t < tlen; t++) {
					pwf.create('ui.intra.team.attendance.ack', {
						'ack':this.get_ack_for(members[m].get('id'), trainings[t].get('id')),
						'member':members[m],
						'tg':trainings[t],
						'parent':row,
					});
				}
			}
		},


		/**
		 * Draw table foot with sums of training acks
		 *
		 * @return void
		 */
		'draw_table_foot':function(proto)
		{
			var
				el = this.get_el('table'),
				trainings = proto.storage.trainings;

			el.foot.html('');
			el.foot.row = pwf.jquery('<tr/>').appendTo(el.foot);

			pwf.jquery('<th/>')
				.html(pwf.locales.trans('attd-sum'))
				.addClass('first')
				.appendTo(el.foot.row);

			for (var i = 0, len = trainings.length; i < len; i++) {
				pwf.create('ui.intra.team.attendance.sum', {
					'acks':this.get_acks_for_tg(trainings[i]),
					'item':trainings[i],
					'parent':el.foot.row
				});
			}
		},


		/**
		 * Show notice saying we have no data
		 *
		 * @return void
		 */
		'draw_no_data':function(proto)
		{
			var el = this.get_el();

			el.empty.html(pwf.locales.trans('attd-no-data'));

			el.table.stop(true).fadeOut();
			el.empty.stop(true).fadeIn();
		},


		'callbacks':{
			'move':function(e, opts)
			{
				e.data.move(opts.dir);
			},

			'sort_members':function(a, b)
			{
				var
					name_a = pwf.site.get_user_name(a.get('user')),
					name_b = pwf.site.get_user_name(b.get('user'));

				return name_a.localeCompare(name_b);
			}
		}
	},


	'public':{
		/**
		 * Load all data necessary to render attendance table
		 *
		 * @param function next
		 * @return this
		 */
		'load':function(proto, next)
		{
			var jobs = [];

			jobs.push(function(next) {
				var parallel = [
					function(next) {
						proto('load_members', next);
					},

					function(next) {
						proto('load_trainings', next);
					}
				];

				pwf.async.parallel(parallel, next);
			});

			jobs.push(function(next) {
				proto('load_acks', next);
			});

			pwf.async.series(jobs, function(ctrl, next) {
				return function(err) {
					proto('loaded');
					ctrl.respond(next, err);
				};
			}(this, next));

			return this.loader_show();
		},


		/**
		 * Get array of loaded training IDs
		 *
		 * @return Array
		 */
		'get_tg_ids':function(proto)
		{
			var list = [];

			for (var i = 0, len = proto.storage.trainings.length; i < len; i++) {
				list.push(proto.storage.trainings[i].get('id'));
			}

			return list;
		},


		/**
		 * Get array of loaded member IDs
		 *
		 * @return Array
		 */
		'get_member_ids':function(proto)
		{
			var list = [];

			for (var i = 0, len = proto.storage.members.length; i < len; i++) {
				list.push(proto.storage.members[i].get('id'));
			}

			return list;
		},


		/**
		 * Browse list of acks and find one for member and tg
		 *
		 * @param int|Impro::Team::Member
		 * @param int|Impro::Team::Training
		 * @return null|Impro::Team::Training::Ack
		 */
		'get_ack_for':function(proto, member, tg)
		{
			for (var i = 0, len = proto.storage.acks.length; i < len; i++) {
				var ack = proto.storage.acks[i];

				if (pwf.model.cmp(ack.get('member'), member) && pwf.model.cmp(ack.get('training'), tg)) {
					return ack;
				}
			}

			return null;
		},


		/**
		 * Get list of all loaded acks for selected training
		 *
		 * @return Array
		 */
		'get_acks_for_tg':function(proto, tg)
		{
			var list = [];

			for (var i = 0, len = proto.storage.acks.length; i < len; i++) {
				var ack = proto.storage.acks[i];

				if (pwf.model.cmp(ack.get('training'), tg)) {
					list.push(ack);
				}
			}

			return list;
		},


		/**
		 * Move selected range of data by dir
		 *
		 * @param int dir
		 * @return void
		 */
		'move':function(proto, dir)
		{
			var
				start = proto.storage.filter.get_input('start'),
				end   = proto.storage.filter.get_input('end'),
				diff  = end.val().diff(start.val(), 'months');

			start.val(start.val().clone().add(diff * dir, 'months'));
			end.val(end.val().clone().add(diff * dir, 'months'));

			return this.load();
		}
	}
});
