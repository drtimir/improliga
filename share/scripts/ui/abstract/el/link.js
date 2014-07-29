pwf.rc('ui.abstract.el.link', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'tag':'a',
			'path':null,
			'title':null,
			'params':null
		}
	},


	'init':function()
	{
		this.get_el()
			.attr('href', pwf.dispatcher.url(this.get('path'), this.get('params')))
			.html(this.get('title'))
			.bind('click', this, function(e) {
				e.preventDefault();

				e.data.get_el().trigger('navigate', {
					'origin':e.data,
					'name':'navigate',
					'title':e.data.get_el().text(),
					'url':e.data.get_el().attr('href')
				});
			});
	}
});
