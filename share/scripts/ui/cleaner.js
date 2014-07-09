pwf.rc('ui.cleaner', {
	'parents':['domel'],

	'proto':{
		'el_attached':function(proto)
		{
			this.get_el().addClass('cleaner');
		}
	}
});
