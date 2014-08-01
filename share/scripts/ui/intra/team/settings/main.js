pwf.rc('ui.intra.team.settings.main', {
	'parents':['ui.abstract.el'],

	'static':{
		'sections':[
			{'name':'general',   'params':{'section':'obecne'},   'ui':'ui.intra.team.settings.general'},
			{'name':'visual',    'params':{'section':'vizualni'}, 'ui':'ui.intra.team.settings.visual'},
			{'name':'locations', 'params':{'section':'umisteni'}, 'ui':'ui.intra.team.settings.locations'},
			{'name':'features',  'params':{'section':'funkce'},   'ui':'ui.intra.team.settings.features'},
			{'name':'members',   'params':{'section':'clenove'},  'ui':'ui.intra.team.settings.members'}
		],


		'get_section':function(name)
		{
			for (var i = 0, len = this.sections.length; i < len; i++) {
				if (this.sections[i].params.section == name) {
					return this.sections[i];
				}
			}

			return null;
		}
	},


	'storage':{
		'opts':{
			'model':'Impro::Team',
			'section':'obecne'
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('create_structure');
			proto('create_heading');
			proto('create_menu');
			proto('create_editor');
		},


		'create_structure':function()
		{
			var el = this.get_el().create_divs(['heading', 'menu', 'content', 'cleaner'], 'team-cfg');

			el.heading.addClass('heading');
			el.cleaner.addClass('cleaner');
		},


		'create_heading':function()
		{
			this.get_el('heading').html(pwf.locales.trans('team-cfg'));
		},


		'create_menu':function()
		{
			var
				el = this.get_el('menu'),
				items = this.meta.static.sections;

			for (var i = 0, len = items.length; i < len; i++) {
				var link = pwf.create('ui.abstract.el.link', {
					'parent':el,
					'path':'team_settings_section',
					'title':pwf.locales.trans('team-cfg-' + items[i].name),
					'params':pwf.merge(items[i].params, {
						'team':this.get('team-seoname')
					})
				});

				if (items[i].params.section == this.get('section')) {
					link.get_el().addClass('active');
				}
			}
		},


		'create_editor':function()
		{
			var section = this.meta.static.get_section(this.get('section'));

			if (section) {
				pwf.create(section.ui, {
					'parent':this.get_el('content'),
					'item':this.get('team')
				}).load();
			}
		},
	}
});
