pwf.rc('ui.user.request.rspn', {
	'parents':['ui.abstract.el'],

	'resolve_class':function(args) {
		if (args.template == 3) {
			return 'ui.user.request.rspn.team';
		}

		return this.name;
	},

	'storage':{
		'opts':{
		}
	}
});
