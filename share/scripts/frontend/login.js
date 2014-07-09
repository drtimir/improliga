pwf.wi(['form'], function()
{
	var get_loader = function(form)
	{
		return form.get_el().find('.loader-tiny');
	};


	pwf.queue.on('login_before_send', function(event) {
		var
			loader = pwf.jquery.div('loader-tiny'),
			group = event.response.get_el().find('.form-group-typed-buttons'),
			button = group.find('button');

		group.find('.err').remove();
		loader.hide().insertAfter(button).fadeIn(250);
	}, null, true);


	pwf.queue.on('login_error', function(event) {
		var loader = get_loader(event.response.form);

		event.response.form.get_el('errors').html(pwf.locales.trans(event.response.error));

		loader.fadeOut(150, function(loader) {
			return function() {
				loader.remove();
			};
		}(loader));
	}, null, true);


	pwf.queue.on('login_ready', function(event) {
		var loader = get_loader(event.response.form);

		loader.fadeOut(250, pwf.jquery.callback_remove);

		if (typeof event.response.response.data.redirect != 'undefined') {
			document.location = event.response.response.data.redirect;
		} else document.location = '/';

	}, null, true);
});
