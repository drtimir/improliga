pwf.rc('ui.list.article', {
	'parents':['domel'],
	'uses':['thumb'],

	'storage':{
		'opts':{
			'item':null
		}
	},

	'proto':{
		'el_attached':function(proto) {
			proto('construct');
		},


		'construct':function(proto) {
			var el = this.get_el().create_divs(['name']);
			el.name.html(this.get('name'));
		},


		'callbacks':{
			'navigate':function(e) {
				pwf.site.navigate(e.data.get_url());
			}
		}
	},

	'public':{
		'get_url':function()
		{
			return '/predstaveni/' + this.get('item').get_seoname();
		}
	}
});
