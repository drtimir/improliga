pwf.rc('ui.abstract.text', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'source':null,
			'locales':null,
			'partial':null
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_ui');
			proto('construct_extra');
		},


		'construct_ui':function(proto)
		{
			var el = this.get_el().create_divs(['inner'], 'ui-text');
		},


		'update_content':function(proto, data)
		{
			this.get_el('inner').html(data);
		}
	},

	'public':{
		'get_source':function()
		{
			var data = pwf.jquery(this.get('source'));

			if (!data.length) {
				data = null;

				if (pwf.locales.trans_msg(this.get('locales'))) {
					data = pwf.locales.trans(this.get('locales'));
				}
			}

			return data;
		},


		'load':function(proto, next)
		{
			var data = this.get_source();

			if (data) {
				proto('update_content', data);
				this.respond(next, [null, this]);
			} else if (this.get('partial')) {
				pwf.jquery.ajax({
					'url':'/static/' + this.get('partial'),
					'dataType':'text',
					'complete':function(ctrl, proto, next) {
						return function(response, status) {
							proto('update_content', response.responseText);
							ctrl.respond(next);
						};
					}(this, proto, next)
				});
			} else {
				v(proto.storage.opts);
				this.respond(next, ['ui-text:failed-to-get-source']);
			}
		}
	}
});
