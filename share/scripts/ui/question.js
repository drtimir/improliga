pwf.rc('ui.question', {
	'parents':['el.popup'],
	'uses':['locales'],

	'storage':{
		'answered':false,
		'opts':{
			'on_answer':null,
			'on_yes':null,
			'on_no':null,
		}
	},

	'proto':{
		'construct':function(p)
		{
			var el = this.get_el('popup');

			el.buttons = pwf.jquery.div('buttons');
			el.append(el.buttons);

			el.yes = pwf.jquery.span('button answer-yes')
				.bind('click', this, p.get('callbacks.yes'))
				.html(pwf.locales.trans('yes'))
				.appendTo(el.buttons);

			el.no = pwf.jquery.span('button answer-no')
				.bind('click', this, p.get('callbacks.no'))
				.html(pwf.locales.trans('no'))
				.appendTo(el.buttons);
		},

		'closed':function(p)
		{
			if (!p.storage.answered) {
				this.respond('on_answer');
				this.respond('on_no');
			}
		},

		'callbacks':
		{
			'yes':function(e) {
				e.data.yes();
			},

			'no':function(e) {
				e.data.no();
			}
		}
	},

	'public':{
		'yes':function(p)
		{
			p.storage.answered = true;

			this.close();
			this.respond('on_answer');
			this.respond('on_yes');
		},

		'no':function(p)
		{
			p.storage.answered = true;

			this.close();
			this.respond('on_answer');
			this.respond('on_no');
		}
	}
});
