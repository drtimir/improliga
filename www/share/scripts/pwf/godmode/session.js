pwf.register('session', function()
{
	var
		self = this,
		sess_windows = [],
		sess_key_windows = 'pwf_godmode_session_windows';
		win_interval = null,
		glow = true;


	this.init = function()
	{
		pwf.when_ready(['window', 'app_drawer'], function(sess_obj) {
			sess_obj.init_stored_windows();
			sess_obj.init_window_refresh();
		}, this);

		return ready = true;
	};


	this.init_stored_windows = function()
	{
		var wins = JSON.parse(pwf.storage.get(sess_key_windows));

		if (typeof wins == 'object' && wins !== null && wins.length > 0) {
			for (var i = 0; i < wins.length; i ++) {
				if (wins[i] !== null) {
					pwf.when_ready(['window'], function(window) {
						pwf.window.create(window);
					}, wins[i]);
				}
			}

			glow = false;
		} else {
			this.start_home_glow();
		}

		return this;
	};


	this.start_home_glow = function()
	{
		glow = true;
		var but = pwf.app_drawer.get_el().find('.menu_0 a');
		home_glow(but);
		but.bind('click.sess', {'obj':this, 'b':but}, function(e) {
			glow = false;
			e.data.b.unbind('click.sess');
		});
	};


	var home_glow = function(but)
	{
		but.animate({"opacity":.25}, 500, function(but) {
			return function() {
				but.animate({"opacity":1}, 500, function(but) {
					return function() {
						if (glow) {
							home_glow(but);
						}
					};
				}(but));
			};
		}(but));
	};


	this.init_window_refresh = function()
	{
		if (win_interval === null) {
			win_interval = setInterval(function(sess_obj) {
				return function() {
					sess_obj.update_windows();
				};
			}(self), 500);
		}

		return this;
	};


	this.update_windows = function()
	{
		var wins = pwf.window.get_all_windows();

		for (var i = 0; i < wins.length; i++) {
			if (typeof wins[i] != 'undefined' && wins[i] !== null) {
				this.update_window(wins[i]);
			} else {
				this.drop_window(i+1);
			}
		}

		return this;
	};


	this.update_window = function(win)
	{
		success = false;

		for (var i = 0; i < sess_windows.length; i++) {
			if (typeof sess_windows[i] === 'object' && sess_windows[i] !== null && sess_windows[i]['id'] == win.attr('id')) {
				sess_windows[i] = win.get_attrs();
				success = true;
			}
		}

		if (success === false) {
			sess_windows.push(win.get_attrs());
		}

		this.save();
		return this;
	};


	this.drop_window = function(id)
	{
		for (var i = 0; i < sess_windows.length; i++) {
			if (typeof sess_windows[i] === 'object' && sess_windows[i] !== null && sess_windows[i]['id'] == id) {
				sess_windows[i] = null;
			}
		}

		this.save();
		return this;
	};


	this.clear = function()
	{
		sess_windows = [];
		pwf.storage.drop(sess_key_windows);
		return this;
	};


	this.save = function()
	{
		sess_windows = filter_windows(sess_windows);
		sess_windows.length === 0 ?
			this.clear():pwf.storage.store(sess_key_windows, JSON.stringify(sess_windows));

		return this;
	};


	var filter_windows = function(arr, func)
	{
		var retObj = [], k;

		func = func || function (v) {return v;};

		for (k in arr) {
			if (func(arr[k])) {
				retObj.push(arr[k]);
			}
		}

		return retObj;
	};
});
