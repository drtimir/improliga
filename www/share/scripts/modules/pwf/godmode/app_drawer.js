$(function() {
	pwf.godmode.register('app_drawer', function()
	{
		var
			self = this,
			el_menu = null,
			el_windows = null,
			windows = [],
			element = null,
			ready = false,
			menu = [
				{
					"label":"godmode_menu",
					"icon":["godmode/actions/fire", 32],
					"callback": function(e) {
						e.preventDefault();
						return pwf.godmode.when_components_are_ready(['main_menu'], function(e) {
							pwf.godmode.components.main_menu.open_close();
						});
					}
				}
			],
			class_window_representation = function(data_win)
			{
				var
					win = data_win,
					els = {
						"container":null,
						"button":null,
					};


				this.create = function()
				{
					els.container = $('<li class="button"></li>');
					els.button    = $('<a href="#"><span></span></a>');
					els.button.bind('click', {"win":win}, function(e) { e.preventDefault(); e.data.win.switch_minimalization(); });

					els.container.append(els.button);
					el_windows.append(els.container);
					return this;
				};


				this.update = function()
				{
					checkout_class("drag", win.attr('drag'));
					checkout_class("minimized", win.attr('minimized'));
				};


				var checkout_class = function(class_name, cond)
				{
					return cond ? els.container.addClass(class_name):els.container.removeClass(class_name);
				};


				this.remove = function()
				{
					els.container.remove();
				};

			};

		this.init = function()
		{
			if (this.exists()) {
				init_elements();
				init_resize();

				return ready = true;
			}

			return false;
		};


		this.is_ready = function()
		{
			return ready;
		};


		this.exists = function()
		{
			return (element = $('#app_drawer')).length === 1;
		};


		var init_resize = function()
		{
			$(window).bind('resize', {'app_drawer':self}, resize_callback);
			resize_callback({"data":{"app_drawer":self}});
		};


		var resize_callback = function(e)
		{
			element.height($(window).height() + 'px');
		};


		var init_elements = function()
		{
			if (el_menu === null) {
				el_menu = $('<menu></menu>');
				element.append(el_menu);

				for (var i = 0; i < menu.length; i++) {
					var opt  = $('<li class="menu_'+i+'"></li>');
					var icon = pwf.godmode.components.icon.html(menu[i].icon[0], menu[i].icon[1]);
					var link = $('<a href="#" title="'+pwf.godmode.trans(menu[i].label)+'">'+icon+'<span class="inner">'+pwf.godmode.trans(menu[i].label)+'</span></a>');

					link.bind('click', menu[i].callback);

					opt.append(link);
					el_menu.append(opt);
				}
			}

			if (el_windows === null) {
				el_windows = $('<ul class="windows"></ul>');
				element.append(el_windows);
			}
		};


		this.get_el = function()
		{
			return element;
		};


		this.add_window = function(win)
		{
			if (typeof windows[win.attr('id')-1] !== 'object') {
				var r = create_window_representation(win);
				r.create();
				windows[win.attr('id')-1] = r;
			}
		};


		var create_window_representation = function(win)
		{
			return new class_window_representation(win);
		};


		this.update_window = function(id)
		{
			var wr = this.get_win(id);
			if (wr !== null) {
				wr.update();
			}
		};


		this.get_win = function(id)
		{
			return typeof windows[id-1] == 'object' ? windows[id-1]:null;
		};


		this.destroy_window = function(id)
		{
			var win = windows[id-1];
			win.remove();
			windows[id-1] = null;
		};
	});
});
