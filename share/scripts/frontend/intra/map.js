pwf.wi(['queue', 'dispatcher', 'model', 'async'], function()
{
	pwf.dispatcher.setup({
		'map':[
			{
				'name':'home',
				'anchor':'/',
				'cname':'ui.structure.section',
				'structure':[
					{
						'cname':'ui.structure.section',
						'pass':{
							'name':'home-summary',
							'structure':[
								'ui.intra.sections.home.profile',
								'ui.intra.sections.home.news'
							]
						}
					},
					{
						'cname':'ui.structure.section',
						'pass':{
							'name':'profile-info',
							'structure':[
								'ui.intra.sections.home.teams'
							]
						}
					},
					'ui.cleaner'
				]
			},

			{
				'name':'teams',
				'anchor':'/tymy',
				'cname':'ui.structure.section',
				'structure':['ui.intra.team.list']
			},

			{
				'name':'team',
				'anchor':'/tymy/{team:seoname}',
				'structure':[
					'ui.intra.sections.team.header',
					'ui.intra.sections.team.home.info',
					'ui.intra.sections.team.home.members',
					'ui.cleaner'
				]
			},

			{
				'name':'team_events',
				'anchor':'/tymy/{team:seoname}/udalosti',
				'structure':[
					'ui.intra.sections.team.header',
					'ui.intra.team.events'
				]
			},


			{
				'name':'team_trainings',
				'anchor':'/tymy/{team:seoname}/treninky',
				'structure':[
					'ui.intra.sections.team.header',
					'ui.intra.team.attendance.browser'
				]
			},

			{
				'name':'team_training',
				'anchor':'/tymy/{team:seoname}/treninky/{tg:int}',
				'structure':[
					'ui.intra.sections.team.header',
				]
			},


			{
				'name':'team_settings',
				'anchor':'/tymy/{team:seoname}/nastaveni',
				'structure':[
					'ui.intra.sections.team.header',
					'ui.intra.team.settings.main'
				]
			},

			{
				'name':'team_settings_section',
				'anchor':'/tymy/{team:seoname}/nastaveni/{section:string}',
				'structure':[
					'ui.intra.sections.team.header',
					'ui.intra.team.settings.main'
				]
			},

			{
				'name':'team_discussion',
				'anchor':'/tymy/{team:seoname}/diskuze',
				'structure':[
					'ui.intra.sections.team.header',
				]
			},



			{
				'name':'user',
				'anchor':'/uzivatel/{user:int}',
				'structure':[]
			},


			{
				'name':'contacts',
				'anchor':'/kontakty',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'shows',
				'anchor':'/predstaveni',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'show',
				'anchor':'/predstaveni/{item:seoname}',
				'structure':['ui.event']
			},

			{
				'name':'workshops',
				'anchor':'/workshopy',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'workshop',
				'anchor':'/workshopy/{item:seoname}',
				'structure':['ui.event']
			},

			{
				'name':'discussions',
				'anchor':'/diskuze',
				'cname':'ui.structure.section',
				'structure':[]
			},

			{
				'name':'shared',
				'anchor':'/sdilene',
				'cname':'ui.structure.section',
				'structure':[]
			}
		],

		'on_load':function(next) {
			var
				el    = pwf.site.get_el(),
				cname = this.get('cname') || 'ui.structure.section',
				opts  = pwf.merge({
					'parent':el,
					'structure':this.get('structure'),
					'name':this.get('name'),
					'vars':this.get('attrs')
				}, this.get('attrs'));

			el
				.html('')
				.trigger('resize')
				.trigger('loading');

			this.set('content', pwf.create(cname, opts).load(function(err) {
				el.trigger('resize');
				el.trigger('ready');
				this.respond(next, [err]);
			}));
		},

		'on_redraw':function(next) {
			this.get('content').update({'vars':this.get('attrs')}).redraw(next);
		},

		'on_error':function() {
			v('page-not-found');
		}
	});

});
