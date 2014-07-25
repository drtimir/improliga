pwf.rc('ui.intra.sections.team.home.info', {
	"parents":['ui.abstract.detail'],

	"storage":{
		"opts":{
			'model':'Impro::Team'
		}
	},


	'init':function(proto)
	{
		this.set('item', this.get('vars.team'));
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			this.get_el().create_divs(['heading', 'props', 'about']);
		},


		'construct':function(proto)
		{
			proto('fill_data');
		},


		'fill_data':function(proto)
		{
			var
				item = this.get('item'),
				el = this.get_el();

			el.heading.html(pwf.locales.trans('intra-team-info'));
			el.about.html(item.get('about'));

			proto('fill_prop', 'city');
			proto('fill_prop', 'mail');
			proto('fill_prop', 'site');
		},


		'fill_prop':function(proto, prop)
		{
			var
				item = pwf.jquery.div('prop prop-' + prop),
				val = this.get('item').get(prop),
				el = this.get_el('props');

			item.create_divs(['icon', 'val']);
			item.val.html(val);
			item.appendTo(el);
		}
	}


});
