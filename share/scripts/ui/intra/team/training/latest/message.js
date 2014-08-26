pwf.rc('ui.intra.team.training.latest.message', {
	'parents':['domel'],

	'proto':{
		'el_attached':function() {
			var
				el = this.get_el().create_divs(['msg', 'date', 'start', 'leader', 'open', 'buttons']);


			el.msg.html(pwf.locales.trans('training-next-planned'));

			el.date.create_divs(['label', 'value']);
			el.start.create_divs(['label', 'value']);
			el.leader.create_divs(['label', 'value']);
			el.open.create_divs(['label', 'value']);

			el.date.label.html(pwf.locales.trans('training-date')).append(':');
			el.start.label.html(pwf.locales.trans('training-start')).append(':');
			el.leader.label.html(pwf.locales.trans('training-lector')).append(':');
			el.open.label.html(pwf.locales.trans('training-is-open')).append(':');

			el.date.value.html(this.get('start').format('DD.MM.YYYY'));
			el.start.value.html(this.get('start').format('HH:mm'));
			el.open.value.html(pwf.locales.trans(this.get('open') ? 'yes':'no'));

			pwf.site.link_user_name(this.get('lector')).append(el.leader.value);
		}
	}
});
