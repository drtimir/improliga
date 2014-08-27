pwf.rc('ui.abstract.detail', {
	'parents':['ui.abstract.el','adminer.abstract.object'],

	'storage':{
		'opts':{
			'attrs':[]
		}
	},


	'proto':{
		'el_attached':function(proto)
		{
			proto('construct_backbone');
		},


		'loaded':function(proto)
		{
			proto('construct');
		},


		'construct':function(proto)
		{
			proto('construct_ui');
			proto('construct_participants');
		},


		'construct_backbone':function(proto)
		{
		},


		'construct_ui':function(proto)
		{
		},


		'create_label':function(proto, name, val)
		{
			var
				el = this.get_el('labels'),
				item = pwf.jquery.div('detail-label').create_divs(['label', 'value']);

			item.label.html(pwf.locales.trans('detail-' + name));

			if (val instanceof Object && typeof val.append == 'function') {
				val.append(item.value);
			} else {
				item.value.html(val);
			}

			el.append(item);
		},
	},

	'public':{
		'format_time':function(proto, date, time)
		{
			var str = [];

			if (date) {
				str.push(date.format('D.M.YYYY'));
			}

			if (time) {
				str.push(time);
			}

			return str.join(' ');
		},


		'format_price':function(proto, item)
		{
			var
				el = pwf.jquery.div('price');


			el.html(item.get('price') + ' Kč');

			return el;
		},


		'format_team':function(proto, team)
		{
			var
				url  = pwf.dispatcher.url('team_detail', {'item':team.get_seoname()});
				link = pwf.jquery('<a/>')
				.attr('href', url)
				.html(team.get('name'));

			return link;
		},


		'link':function(proto, title, url)
		{
			return pwf.jquery('<a/>')
				.attr('href', url)
				.html(title);
		}
	}
});
