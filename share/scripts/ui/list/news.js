pwf.rc('ui.list.news', {
	'parents':['domel'],

	'storage':{
		'opts':{
			'item':null
		}
	},

	'proto':{
		'el_attached':function(proto)
		{
			proto('construct');
			proto('fill');
		},


		'construct':function(proto)
		{
			this.get_el().create_divs(['name', 'text', 'footer']);
		},


		'fill':function()
		{
			var el = this.get_el();

			el.name.html(this.get('name'));
			el.text.html(pwf.jquery.div('text').html(this.get('text')).text());
			el.footer.html(this.get('created_at').format('D.M. h:mm'));

		}
	}
});
