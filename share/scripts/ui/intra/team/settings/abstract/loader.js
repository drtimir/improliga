pwf.rc('ui.intra.team.settings.abstract.loader', {
	'parents':['ui.abstract.el.async', 'adminer.editor'],

	'proto':{
		'loaded':function(proto)
		{
			proto('send_signal');
			proto('construct');

			this.respond('on_load');
			this.loader_hide();
		},


		'before_load':function(proto)
		{
			this.loader_show();
		},
	}
});
