pwf.rc('ui.intra.editor.event', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'model':'Impro::Event',
			'exclude':['image', 'price', 'price_student', 'canceled', 'acks', 'author', 'desc_short', 'capacity', 'publish_at', 'publish_wait', 'published']
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

		proto.storage.opts.inputs.type = {
			'required':true
		};

		proto.storage.opts.inputs.start =
		proto.storage.opts.inputs.end = {
			'value':pwf.moment()
		};

		proto.storage.opts.inputs.start_time =
		proto.storage.opts.inputs.end_time = {
			'label':pwf.locales.trans('intra-input-time'),
			'placeholder':true,
		};

		proto.storage.opts.inputs.type = {
			'type':'select',
			'on_change':function(val)
			{
				var
					home  = this.get('form').get_input('team_home'),
					away  = this.get('form').get_input('team_away');

				if (val == 2) {
					away.get_el().show();
					home.get_el('label')
						.html(pwf.locales.trans_attr('Impro::Event', 'team_home'))
						.append('<span class="label-sep">:</span>');
				} else {
					away.get_el().hide().val(null);
					home.get_el('label')
						.html(pwf.locales.trans_attr('Impro::Event', 'team_master'))
						.append('<span class="label-sep">:</span>');
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
