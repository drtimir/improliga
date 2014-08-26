pwf.rc('ui.intra.editor.config.password', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'heading':'intra-menu-config-password-change',
			'model':'System::User',
			'url':'/api/user/password',
			'attrs':['password']
		}
	},


	'init':function() {
		this.set('item', pwf.site.get_user());
	}
});
