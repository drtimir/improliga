pwf.rc('ui.link', {
	'parents':['domel', 'caller'],

	'storage':{
		'opts':{
			'cname':'',
			'deep':false,
			'event':'navigate',
			'path':null,
			'params':{},
			'propagate':true,
			'tag':'a',
			'send':null,
			'title':null
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
				var send = e.data.get('send');

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

				if (send instanceof Array) {
					for (var i = 0, len = send.length; i < len; i++) {
						e.data.get_el().trigger(send[i], {'origin':e.data});
					}
				}
			}
		}
	}
});
