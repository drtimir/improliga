pwf.rc('ui.intra.editor.training', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'names':{
			'open':'Otevřený trénink',
			'closed':'Uzavřený trénink'
		},

		'opts':{
			'model':'Impro::Team::Training',
			'exclude':['canceled', 'acks', 'author']
		}
	},


	'init':function(proto)
	{
		var
			opts = pwf.site.get_user_teams(),
			data = {
				'name':'Uzavřený trénink'
			};

		proto.storage.opts.inputs.team = {
			'type':'select',
			'options':opts,
			'on_change':function(val)
			{
				var
					input = this.get('form').get_input('location'),
					team  = pwf.model.find_existing('Impro::Team', val);

				input.val(team.get('loc_trainings'));
			}
		};

		proto.storage.opts.inputs.open = {
			'on_change':function(val)
			{
				var
					input = this.get('form').get_input('name'),
					name  = input.val();

				if (!name || name == proto.storage.names.open || name == proto.storage.names.closed) {
					input.val(proto.storage.names[val ? 'open':'closed']);
				}
			}
		};

		if (opts.length) {
			data.location = opts[0].get('loc_trainings');
		}

		if (this.get('item') === null) {
			this.set('item', pwf.model.create(this.get('model'), data));
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
