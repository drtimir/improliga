pwf.register('app_drawer', function()
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
					e.stopPropagation();

					return pwf.main_menu.open_close();
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
				els.button    = $('<a href="#"></a>');
				els.icon      = $(pwf.icon.html(win.attr('icon'), 32));

				els.button.append(els.icon);
				els.button.bind('click', {"win":win}, function(e) {
					e.preventDefault();
					if (e.data.win.is_active()) {
						e.data.win.switch_minimalization();
					} else {
						e.data.win.focus();
					}
				});

				els.container.append(els.button);
				el_windows.append(els.container);
				return this;
			};


			this.update = function()
			{
				checkout_class("drag", win.attr('drag'));
				checkout_class("minimized", win.attr('minimized'));
				checkout_class("active", win.is_active());
			};


			var checkout_class = function(class_name, cond)
			{
				return cond ? els.container.addClass(class_name):els.container.removeClass(class_name);
			};


			this.remove = function()
			{
				els.container.remove();
			};


			this.get_win = function()
			{
				return win;
			};


			this.w = function()
			{
				return win;
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
				var icon = pwf.icon.html(menu[i].icon[0], menu[i].icon[1]);
				var link = $('<a href="#" title="'+pwf.locales.trans(menu[i].label)+'">'+icon+'<span class="inner">'+pwf.locales.trans(menu[i].label)+'</span></a>');

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
		var r = create_window_representation(win);
		r.create();
		r.update();
		windows.push(r);
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


	this.update_windows = function()
	{
		for (var i = 0; i<windows.length; i++) {
			if (windows[i] !== null) {
				windows[i].update();
			}
		}
	};


	this.get_win = function(id)
	{
		for (var i = 0; i < windows.length; i++) {
			if (typeof windows[i] == 'object' && windows[i] !== null && windows[i].w().attr('id') == id) {
				return windows[i];
			}
		}

		return null;
	};


	this.destroy_window = function(id)
	{
		for (var i = 0; i < windows.length; i++) {
			if (typeof windows[i] === 'object' && windows[i] !== null && windows[i].w().attr('id') == id) {
				windows[i].remove();
				windows[i] = null;
			}
		}
	};
});
