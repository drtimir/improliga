$(function(){
	pwf.godmode.register('session', function()
	{
		var
			self = this,
			sess_windows = [],
			sess_key_windows = 'pwf_godmode_session_windows';
			win_interval = null;


		this.init = function()
		{
			pwf.godmode.when_components_are_ready(['window'], function(sess_obj) {
				sess_obj.init_stored_windows();
				sess_obj.init_window_refresh();
			}, this);

			return ready = true;
		};


		this.init_stored_windows = function()
		{
			var wins = JSON.parse(pwf.storage.get(sess_key_windows));

			if (typeof wins == 'object' && wins !== null) {
				for (var i in wins) {
					if (wins[i] !== null) {
						pwf.godmode.components.window.create(wins[i]);
					}
				}
			}

			return this;
		};


		this.init_window_refresh = function()
		{
			if (win_interval === null) {
				win_interval = setInterval(function(sess_obj) {
					return function() {
						sess_obj.update_windows();
					};
				}(self), 1000);
			}

			return this;
		};


		this.update_windows = function()
		{
			var wins = pwf.godmode.components.window.get_all_windows();
			//~ v(wins);

			for (var i = 0; i < wins.length; i++) {
				if (wins[i] !== null) {
					this.update_window(wins[i]);
				} else {
					this.drop_window(i+1);
				}
			}

			return this;
		};


		this.update_window = function(win)
		{
			sess_windows[win.attr('id')-1] = win.get_attrs();
			this.save();
			return this;
		};


		this.drop_window = function(id)
		{
			delete sess_windows[id];
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
			//~ v(windows.length);

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
});
