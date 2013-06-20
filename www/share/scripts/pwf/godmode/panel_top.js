pwf.register('panel_top', function()
{
	var
		self = this,
		ready = false,
		el_left = null,
		el_right = null,
		el_logout = null,
		el_homepage = null,
		el_time = null,
		el_locale = null,
		el_time_timer = null,
		el_user = null,
		el_shortcuts = null,
		element = null;

	this.init = function()
	{
		if (this.exists()) {

			init_elements();

			return ready = true;
		} else return ready = false;
	};


	this.is_ready = function()
	{
		return ready;
	};


	this.exists = function()
	{
		return (element = $('#panel_top')).length === 1;
	};


	var init_elements = function()
	{
		if (el_left === null) {
			element.append(el_left = $('<div class="left"></div>'));
		}

		if (el_right === null) {
			element.append(el_right = $('<div class="right"></div>'));
		}

		if (el_logout === null) {
			var icon = pwf.icon.html('godmode/actions/logout', 16);
			el_right.append(el_logout = $('<a href="/god/logout" class="logout" title="'+pwf.locales.trans('godmode_logout')+'">'+icon+'</a>'));
		}

		if (el_homepage === null) {
			var icon = pwf.icon.html('godmode/locations/home', 16);
			el_right.append(el_homepage = $('<a href="/" class="homepage" title="'+pwf.locales.trans('godmode_homepage')+'">'+icon+'</a>'));
		}

		if (el_user === null) {
			el_left.append(el_user = $('<span class="block user">'+pwf_user.name+'</span>'));
		}

		if (el_time === null) {
			init_time_el();
		}

		if (el_locale === null) {
			el_left.append(el_user = $('<span class="block user">'+pwf_locale+'</span>'));
		}

		if (el_shortcuts === null) {
			el_left.append(el_shortcuts = $('<span class="block shortcuts"></span>'));
			el_shortcuts.bind('click', {"obj":self}, function(e) { e.preventDefault(); pwf.shortcuts.switch_mode(); });
			self.update_shortcuts();
		}
	};


	var init_time_el = function()
	{
		el_left.append(el_time = $('<span class="block time"></span>'));

		el_time_timer = setInterval(el_callback, 1000);
		el_callback();
	};


	var el_callback = function()
	{
		var now = new Date();
		var str = now.toLocaleDateString() + ' ' + now.toLocaleTimeString()
		el_time.html(str);
	};


	this.get_el = function()
	{
		return element;
	};


	this.update_shortcuts = function()
	{
		pwf.when_ready(['shortcuts'], function() {
			var on = pwf.shortcuts.are_on();
			el_shortcuts.html(pwf.locales.trans(on ? 'godmode_shortcuts_on':'godmode_shortcuts_off'));
			on ? el_shortcuts.addClass('active'):el_shortcuts.removeClass('active');
		});
	};
});
