pwf.rc('ui.intra.editor.event', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Event',
			'exclude':['canceled', 'acks', 'author', 'desc_short', 'capacity', 'publish_at', 'publish_wait', 'published']
		}
	},


	'init':function(proto)
	{
		var
			opts = pwf.site.get_user_teams(),
			data = {};

		proto.storage.opts.inputs.team_home = {
			'type':'select',
			'options':opts
		};

		proto.storage.opts.inputs.start =
		proto.storage.opts.inputs.end =
		proto.storage.opts.inputs.start_time =
		proto.storage.opts.inputs.end_time = {
			'placeholder':true
		};

		proto.storage.opts.inputs.type = {
			'type':'select',
			'on_change':function(val)
			{
				var
					home  = this.get('form').get_input('team_home'),
					away  = this.get('form').get_input('team_away');

				if (val == 2) {
					home.get_el('label').html(pwf.locales.trans_attr('Impro::Event', 'team_home'));
					away.get_el().show();
				} else {
					home.get_el('label').html(pwf.locales.trans_attr('Impro::Event', 'team_master'));
					away.get_el().hide().val(null);
				}

				this.get_el().trigger('resize');
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
