pwf.rc('ui.abstract.el.async', {
	'parents':['ui.abstract.el'],


	'init':function(proto)
	{
		this.get_el().create_divs(['loader'], 'ui-generic');
	},


	'public':{
		/**
		 * Display precreated loader element
		 *
		 * @return this
		 */
		'loader_show':function()
		{
			this.get_el('loader').stop(true).fadeIn(200);
			return this;
		},


		/**
		 * Hide precreated loader element
		 *
		 * @return this
		 */
		'loader_hide':function()
		{
			this.get_el('loader').stop(true).fadeOut(200);
			return this;
		},
	}
});
