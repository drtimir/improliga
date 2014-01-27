pwf.wi(['form'], function()
{
	var get_loader = function(form)
	{
		return form.el().find('.loader-tiny');
	};


	pwf.queue.on('login_before_send', function(event) {
		var
			loader = pwf.jquery.div('loader-tiny'),
			group = event.response.el().find('.form-group-typed-buttons'),
			button = group.find('button');

		group.find('.err').remove();
		loader.hide().insertAfter(button).fadeIn(250);
	}, null, true);

	pwf.queue.on('login_error', function(event) {
		var
			loader = get_loader(event.response.form),
			msg = pwf.jquery.div('err').html(pwf.locales.trans(event.response.err));

		msg.hide().insertAfter(loader);
		loader.fadeOut(150, function(loader, msg) {
			return function() {
				loader.remove();
				msg.fadeIn(150);
			};
		}(loader, msg));
	}, null, true);

	pwf.queue.on('login_ready', function(event) {
		v(event);
		var loader = get_loader(event.response.form);
		loader.fadeOut(250, pwf.jquery.callback_remove);
	}, null, true);
});
