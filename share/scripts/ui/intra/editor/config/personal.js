pwf.rc('ui.intra.editor.config.personal', {
	'parents':['ui.abstract.popup.editor'],

	'storage':{
		'opts':{
			'heading':'intra-menu-config-personal',
			'model':'System::User',
			'exclude':['password', 'contacts', 'groups', 'last_login', 'author']
		}
	},


	'init':function() {
		this.set('item', pwf.site.get_user());
	}
});
