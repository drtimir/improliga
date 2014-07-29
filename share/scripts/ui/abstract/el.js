pwf.rc('ui.abstract.el', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'center':false,
			'parallax':false
		}
	},

	'proto':{
		'update_classes':function() {
			var el = this.get_el();

			el[this.get('center') ? 'addClass':'removeClass']('structure-el-center');
			el[this.get('parallax') ? 'addClass':'removeClass']('structure-el-parallax');
		}
	}
});
