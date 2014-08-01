pwf.rc('ui.abstract.el.link', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'tag':'a',
			'cname':'',
			'path':null,
			'deep':false,
			'title':null,
			'params':null
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct');
		},


		'construct':function(proto)
		{
			var
				url = pwf.dispatcher.url(this.get('path'), this.get('params')),
				el  = this.get_el();

			el
				.attr('href', url)
				.addClass(this.get('cname'))
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

			if (url == pwf.dispatcher.get_path() || (this.get('deep') && pwf.dispatcher.get_path().indexOf(url) === 0)) {
				el.addClass('active');
			}
		}
	}
});
