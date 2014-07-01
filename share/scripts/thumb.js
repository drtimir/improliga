pwf.register('thumb', function() {
	this.is_ready = function()
	{
		return pwf.mi(['jquery', 'comm']);
	};


	this.get_url = function(url, size)
	{
		var
			schema = document.location.protocol == 'https:' ? 'https:':'http:',
			url = pwf.comm.url('/api/thumb/?name=' + url + '&size=' + size),
			separator = '//';

		if (url.indexOf('//') === 0) {
			separator = '';
		}

		return schema + separator + url;
	};


	this.create = function(url, size)
	{
		return pwf.jquery('<img/>').attr('src', this.get_url(url, size));
	};


	this.fit = function(url, el)
	{
		return this.create(url, el.width() + 'x' + el.height()).appendTo(el);
	};
});
