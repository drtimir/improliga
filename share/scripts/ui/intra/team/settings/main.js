pwf.rc('ui.intra.team.settings.main', {
	'parents':['ui.abstract.el.async', 'adminer.abstract.object'],

	'static':{
		'sections':[
			{'name':'general',   'params':{'section':'obecne'},   'ui':'ui.intra.team.settings.general'},
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
			'model':'Impro::Team'
		}
	},


	'init':function(proto)
	{
		this.set('item', this.get('team'));
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('create_structure');
		},


		'create_structure':function()
		{
			var el = this.get_el().create_divs(['menu', 'content', 'cleaner'], 'team-cfg');

			el.cleaner.addClass('cleaner');
		},


		'loaded':function(proto)
		{
			this.loader_hide();

			proto('create_menu');
			proto('create_editor');
		},


		'before_load':function(proto)
		{
			this.loader_show();
		},


		'create_menu':function()
		{
			var
				el = this.get_el('menu'),
				items = this.meta.static.sections;

			for (var i = 0, len = items.length; i < len; i++) {
				pwf.create('ui.abstract.el.link', {
					'parent':el,
					'path':'team_settings_section',
					'title':pwf.locales.trans('team-cfg-' + items[i].name),
					'params':pwf.merge(items[i].params, {
						'team':this.get('item').get_seoname()
					})
				});
			}
		},


		'create_editor':function()
		{
			var section = this.meta.static.get_section(this.get('section'));

			if (section) {
				pwf.create(section.ui, {
					'parent':this.get_el('content'),
					'item':this.get('item')
				}).load();
			}
		},
	}
});
