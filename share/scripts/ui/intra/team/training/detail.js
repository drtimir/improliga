pwf.rc('ui.intra.team.training.detail', {
	"parents":['ui.abstract.detail'],

	"storage":{
		"opts":{
			'model':'Impro::Team::Training'
		}
	},


	'init':function(proto) {
		this.set('item', this.get('vars.tg'));
	},


	'proto':{
		'construct_backbone':function(p)
		{
			var el = this.get_el().create_divs(['header', 'labels', 'desc', 'acks', 'rspn']);

			el.header.create_divs(['heading', 'date']);
		},


		'construct_ui':function(p)
		{
			var
				el = this.get_el(),
				item = this.get('item');

			el.header.heading.html(item.get('name'));
			el.header.date.html(item.get('start').format('D.M.YYYY'));

			if (item.get('location')) {
				p('create_label', 'location', pwf.create('ui.location', item.get('location').get_data()));
			}

			p('create_label', 'start', item.get('start').format('H:mm'));

			if (item.get('lector')) {
				p('create_label', 'lector', pwf.site.link_user_name(item.get('lector')));
			}

			p('create_label', 'is-open', pwf.locales.trans(item.get('open') ? 'yes':'no'));


			el.desc.html(item.get('desc'));
		}
	}
});
