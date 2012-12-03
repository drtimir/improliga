$(function(){
	pwf.godmode.register('panel_top', function()
	{
		var
			self = this,
			el_left = null,
			el_right = null,
			el_logout = null,
			el_homepage = null,
			el_time = null,
			el_locale = null,
			el_time_timer = null,
			el_user = null,
			element = null;

		this.init = function()
		{
			if (this.exists()) {

				init_elements();

				return true;
			} else return false;
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
				el_right.append(el_logout = $('<a href="/god/logout" class="logout"><span>'+pwf.godmode.trans('godmode_logout')+'</span></a>'));
			}

			if (el_homepage === null) {
				el_right.append(el_homepage = $('<a href="/" class="homepage"><span>'+pwf.godmode.trans('godmode_homepage')+'</span></a>'));
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
	});
});
