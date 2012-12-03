$(function() {
	pwf.godmode.register('shortcuts', function()
	{
		var
			self = this,
			ready = false,
			global_selector = 'body',
			shortcuts = [
				{"key":67, "alt":true, "callback":function() {
					var win = pwf.godmode.components.window.get_active();

					if (win !== null) {
						win.close();
					}
				}},
				{"key":91, "callback":function() {
					pwf.godmode.components.main_menu.open_close();
				}}
			];


		this.init = function()
		{
			init_shortcuts();
			return ready = true;
		};


		var init_shortcuts = function()
		{
			$(global_selector).bind('keyup', {"keyobj":self}, function(e) {
				e.data.keyobj.fire(e);
			});

		};


		this.fire = function(e)
		{
			var ctrl = false;
			var alt  = false;

			for (var i = 0; i < shortcuts.length; i++) {

				if (shortcuts[i].key == e.keyCode) {
					ctrl = typeof shortcuts[i].ctrl == 'undefined' || !shortcuts[i].ctrl || (shortcuts[i].alt && e.ctrlKey);
					alt = typeof shortcuts[i].alt == 'undefined' || !shortcuts[i].alt || (shortcuts[i].alt && e.altKey);

					if (alt && ctrl) {
						e.preventDefault();
						shortcuts[i].callback();
					}
				}
			}
		};
	});
});
