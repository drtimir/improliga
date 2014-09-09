pwf.rc('ui.link', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'tag':'a',
			'cname':'',
			'path':null,
			'deep':false,
			'title':null,
			'params':{},
			'propagate':true,
			'event':'navigate'
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
				.bind('click', this, proto('callbacks').open);

			if (this.get('title')) {
				el.html(pwf.locales.trans(this.get('title')));
			}

			if (url == pwf.dispatcher.get_path() || (this.get('deep') && pwf.dispatcher.get_path().indexOf(url) === 0)) {
				el.addClass('active');
			}
		},


		'callbacks':
		{
			'open':function(e) {
				e.preventDefault();

				if (!e.data.get('propagate')) {
					e.stopPropagation();
				}

				e.data.get_el().trigger(e.data.get('event'), {
					'origin':e.data,
					'name':e.data.get('event'),
					'title':e.data.get_el().text(),
					'url':e.data.get_el().attr('href')
				});
			}
		}
	}
});
