pwf.rc('ui.abstract.list.empty', {
	'parents':['domel'],

	'storage':{
		'opts':{
			'message':'list-empty'
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct');
		},


		'construct':function(proto)
		{
			this.get_el().html(pwf.locales.trans(this.get('message')));
		}
	}
});
