pwf.rc('ui.intra.sections.team.header', {
	"parents":['ui.abstract.detail'],

	"storage":{
		"opts":{
			'model':'Impro::Team',
		}
	},


	'init':function(proto)
	{
		this.set('item', this.get('vars.team'));
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['logo', 'name']);

			el.name.create_divs(['long', 'short']);
		},


		'construct':function(proto)
		{
			var
				item = this.get('item'),
				el = this.get_el();

			el.name.long.html(item.get('name'));
			el.name.short.html(item.get('name_short'));
			pwf.thumb.fit(item.get('logo').path, el.logo);
		}
	}


});
