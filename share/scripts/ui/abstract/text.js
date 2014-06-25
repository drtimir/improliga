pwf.rc('ui.abstract.text', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'source':null
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


		'update_content':function()
		{
			this.get_el('inner').html(this.get_source().html());
		}
	},

	'public':{
		'get_source':function()
		{
			return pwf.jquery(this.get('source'));
		},


		'load':function(proto, next)
		{
			proto('update_content');
			this.respond(next, [null, this]);
		}
	}
});
