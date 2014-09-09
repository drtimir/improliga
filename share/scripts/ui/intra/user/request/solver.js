pwf.rc('ui.user.request.solver', {
	'parents':['ui.abstract.detail'],

	'storage':{
		'opts':{
			'model':'Impro::User::Alert',
			'attrs':['team']
		}
	},


	'init':function(proto) {
		this.set('item', this.get('vars.rq'));
	},


	'proto':{
		'construct_ui':function(p)
		{
			var
				item = this.get('item'),
				render = true;

			if (!pwf.model.cmp(pwf.site.get_user(), item.get('user'))) {
				v('not mine');
				render = false;
			}

			if (item.get('response') !== null) {
				v('already answered');
				render = false;
			}

			if (item.get('type') !== 2) {
				v('not a request');
				render = false;
			}

			if (render) {
				pwf.resolve('ui.user.request.rspn', {
					'data':pwf.merge(item.get_data(), {
						'alert':item.get('id'),
						'team':item.get('team').get('id')
					}),
					'item':item,
					'parent':this.get_el(),
					'team':item.get('team'),
					'template':item.get('template')
				});
			}
		}
	}

});
