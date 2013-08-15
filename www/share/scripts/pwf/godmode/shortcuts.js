pwf.register('shortcuts', function()
{
	var
		self = this,
		on = false,
		global_selector = 'body',
		shortcuts = [
			{"key":87, "callback":function() {
				var win = pwf.window.get_active();

				if (win !== null) {
					win.close();
				}
			}},
			{"key":77, "callback":function() { pwf.main_menu.open_close(); }}
		];


	this.init = function()
	{
		init_shortcuts();
		return true;
	};


	this.is_ready = function()
	{
		return pwf.components_ready(['main_menu', 'window']);
	};


	var init_shortcuts = function()
	{
		$(global_selector).bind('keyup', {"keyobj":self}, function(e) { e.data.keyobj.fire(e); });
		$(global_selector).bind('keydown', {"keyobj":self}, function(e) {
			if (e.ctrlKey && (e.which === 60 || e.which === 220)) {
				e.preventDefault();
				e.stopPropagation();
				e.data.keyobj.switch_mode();
			} else {
				if (e.data.keyobj.are_on()) {
					e.preventDefault();
				}
			}
		});
	};


	this.switch_mode = function()
	{
		on = !on;
		pwf.when_ready(['panel_top'], function() { pwf.panel_top.update_shortcuts(); });
	};


	this.are_on = function()
	{
		return on;
	};


	this.fire = function(e)
	{
		if (on) {
			var ctrl = false;
			var alt  = false;

			for (var i = 0; i < shortcuts.length; i++) {

				if (shortcuts[i].key == e.keyCode) {
					ctrl = typeof shortcuts[i].ctrl == 'undefined' || !shortcuts[i].ctrl || (shortcuts[i].alt && e.ctrlKey);
					alt = typeof shortcuts[i].alt == 'undefined' || !shortcuts[i].alt || (shortcuts[i].alt && e.altKey);

					if (alt && ctrl) {
						e.preventDefault();
						e.stopPropagation();
						shortcuts[i].callback();
					}
				}
			}
		}
	};
});
