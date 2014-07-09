pwf.rc('ui.intra.sections.home.profile', {
	'parents':['ui.abstract.detail'],


	'init':function()
	{
		this.set('item', pwf.site.get_user().get('id'));
	},


	'storage':{
		'opts':{
			'model':'System::User'
		}
	},


	'proto':{
		'construct_backbone':function(proto)
		{
			var el = this.get_el().create_divs(['avatar', 'info', 'name', 'cleaner']);

			el.info.append(el.name);
			el.name.addClass('heading');
		},


		'construct_ui':function(proto)
		{
			var
				el = this.get_el(),
				item = this.get('item');

			el.name.html(pwf.site.get_user_name(item));
			pwf.thumb.fit(item.get('avatar').path, el.avatar);
		}
	}

});
