pwf.rc('ui.intra.editor.training', {
	'parents':['adminer.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Team::Training',
			'exclude':['canceled', 'acks', 'author']
		}
	},


	'init':function(proto)
	{
		var
			user  = pwf.site.get_user(),
			roles = user.get('roles'),
			opts  = [];

		for (var i = 0, len = roles.length; i < len; i++) {
			opts.push(roles[i].get('team'));
		}

		proto.storage.opts.inputs.team = {
			'type':'select',
			'options':opts
		};

		if (this.get('item') === null) {
			this.set('item', pwf.model.create(this.get('model')));
		}
	},


	'public':{
		'load':function(proto, next)
		{
			proto('before_load');
			proto('load_obj_data', next);
			return this;
		}
	}
});
