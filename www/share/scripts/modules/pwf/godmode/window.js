$(function(){
	pwf.godmode.register('window', function()
	{
		var
			self = this,
			win = this,
			element = null,
			ready = false,
			window_active = null,
			window_drag = null,
			windows = [],
			window_ctrls = [
				{
					"selector":"refresh",
					"callback":function(e) {
						e.preventDefault();
						e.data.win.refresh();
					}
				}
			],
			class_window = function(data)
			{
				var
					attrs = {
						"id":0,
						"icon":0,
						"title":"Undefined",
						"title_base":'',
						"title_base_stays":true,
						"position":{"x":20, "y":20},
						"position_restore":{"x":20, "y":20},
						"size":{"x":720, "y":520},
						"size_restore":{"x":640, "y":480},
						"drag":false,
						"maximized":false,
						"minimized":false,
						"rolled_up":false,
						"url":'',
						"resize_to_fit":false,
					},
					els = {
						"border":null,
						"container":null,
						"title_container":null,
						"icon":null,
						"title":null,
						"menu":null,
						"buttons":null,
						"button_close":null,
						"button_maximize":null,
						"button_minimize":null,
						"button_roll":null,
						"content_container":null,
						"content":null
					},
					drag_last_cursor_pos = null;


				if (typeof data !== 'undefined') {

					if (typeof data.title === 'undefined') {
						attrs.title_base_stays = false;
					} else {
						attrs.title_base = data.title;
					}

					for (var i in data) {
						if (typeof attrs[i] != 'undefined') {
							attrs[i] = data[i];
						}
					}

				} else throw "You must input window data when creating new window.";


				this.attr = function(attr, value)
				{
					if (typeof attrs[attr] != 'undefined') {
						if (typeof value != 'undefined') {
							attrs[attr] = value;
						}

						return attrs[attr];
					} else throw "Attribute "+attr+" does not exist for window instance";
				};


				this.create = function()
				{
					create_base(this);
					create_buttons(this);
					var size = this.attr('size');

					this.title(this.attr('title'));
					this.focus();
					this.resize(size.x, size.y);
					this.update_size();
					this.reset_events();
					this.load_content();
					return this;
				};


				this.get_attrs = function()
				{
					return attrs;
				};


				var create_base = function(ref)
				{
					els.border = $('<div class="window"></div>');
					els.container = $('<div class="window-inner"></div>');
					els.title_container = $('<div class="window-title-container"></div>');
					els.icon = $('<span class="window-icon">' + pwf.godmode.components.icon.html(ref.attr('icon'), 16) + '</span>');
					els.title = $('<span class="window-title"></span>');
					els.menu = $('<menu class="window-menu"></menu>');
					els.buttons = $('<ul class="window-buttons"></ul>');
					els.content_container = $('<div class="window-content-container"></div>');
					els.content = $('<div class="window-content"></div>');
					els.preloader = $('<div class="window-preloader"><span>'+pwf.godmode.trans('godmode_please_wait')+'</span></div>');

					els.title_container.append(els.icon);
					els.title_container.append(els.title);
					els.title_container.append(els.menu);
					els.title_container.append(els.buttons);
					els.content_container.append(els.content);

					els.container.append(els.title_container);
					els.container.append(els.content_container);
					els.container.append(els.preloader);

					els.border.bind('click', {"win":ref}, function(e) { e.data.win.focus(); });

					els.border.append(els.container);
				};


				var create_buttons = function(ref)
				{
					els.button_close = $('<li class="button close"><a href="" title="'+pwf.godmode.trans('godmode_close')+'"><span></span></a></li>');
					els.button_close.bind('click', {"win":ref}, function(e) { e.preventDefault(); e.data.win.close();  });

					els.button_maximize = $('<li class="button maximize"><a href="" title="'+pwf.godmode.trans('godmode_maximize')+'"><span></span></a></li>');
					els.button_maximize.bind('click', {"win":ref}, function(e) { e.preventDefault(); e.data.win.switch_maximization();  });

					els.button_minimize = $('<li class="button minimize"><a href="" title="'+pwf.godmode.trans('godmode_minimize')+'"><span></span></a></li>');
					els.button_minimize.bind('click', {"win":ref}, function(e) { e.preventDefault(); e.data.win.minimize();  });

					els.button_roll = $('<li class="button roll"><a href="" title="'+pwf.godmode.trans('godmode_roll')+'"><span></span></a></li>');
					els.button_roll.bind('click', {"win":ref}, function(e) { e.preventDefault(); e.data.win.roll(); });

					els.buttons.append(els.button_close);
					els.buttons.append(els.button_maximize);
					els.buttons.append(els.button_minimize);
					els.buttons.append(els.button_roll);
				};


				this.update_pos = function()
				{
					var offset = pwf.godmode.components.viewport.get_offset();
					var pos = this.get_el('border').offset();

					this.attr('position', {"x":pos.left - offset.left, "y":pos.top - offset.top});
				};


				this.update_size = function()
				{
					var el_base  = this.get_el('border');
					var el_title = this.get_el('title_container');
					var el = this.get_el('content');

					var w = el_base.width();
					var h = el_base.height() - el_title.height();
					var size = this.attr('size');

					w = w > 0 ? w:size.x;
					h = h > 0 ? h:size.y;

					this.resize(w, h);
				};


				this.resize = function(w, h)
				{
					var el = this.get_el('content');
					var el_title = this.get_el('title_container');

					el.width(w);
					el.height(h);
					el_title.width(w);
					this.attr("size", {"x":w, "y":h});
					return this;
				};


				this.resize_to_fit = function()
				{
					var
						el_menu = this.find('.window-content-menu'),
						el_content = this.find('.window-content-inner'),
						w = el_content.width(),
						h = el_menu.outerHeight() + el_content.outerHeight();

					return this.resize(w, h);
				};


				this.get_container = function()
				{
					return els.border;
				};


				this.reset_events = function()
				{
					this.get_el('title_container').bind('mousedown', {"win":this}, function(e) { e.data.win.start_drag(e); });
				};


				this.show = function()
				{
					pwf.godmode.when_components_are_ready(['viewport', 'app_drawer'], function(win) {
						pwf.godmode.components.viewport.add_window(win);
						pwf.godmode.components.app_drawer.add_window(win);
					}, this);
					return this;
				};


				this.find = function(selector)
				{
					return this.get_el('content').find(selector);
				};


				this.title = function(tit)
				{
					if (typeof tit != 'undefined') {
						this.attr('title', tit)
						this.get_el('title').html(this.get_title_str());
					}

					return this.get_title_str();
				};


				this.get_title_str = function()
				{
					return (this.attr('title_base_stays') && this.attr('title_base') != this.attr('title') ? this.attr('title_base') + ' - ':'') + this.attr('title');
				};


				this.focus = function()
				{
					pwf.godmode.components.window.unfocus_all();
					pwf.godmode.components.window.set_active(this);
					els.border.addClass('active').css({"z-index":100});
					pwf.godmode.components.window.set_active(this);

					if (typeof pwf.godmode.components.app_drawer === 'object') {
						pwf.godmode.components.app_drawer.update_windows();
					}

					return this;
				};


				this.unfocus = function()
				{
					this.get_el('border').removeClass('active').css({"z-index":50});
					return this;
				};


				this.is_active = function()
				{
					return typeof window_active !== 'undefined' && window_active !== null && window_active.attr('id') === this.attr('id');
				};


				this.get_el = function(name)
				{
					return typeof els[name] == 'undefined' ? null:els[name];
				};


				this.start_drag = function(e)
				{
					pwf.godmode.components.viewport.get_el().bind('mousemove.godmode_window', {"win":this}, function(e) {
						if (e.data.win.attr('drag')) { e.data.win.drag_reposition(e.pageX, e.pageY); };
					});

					pwf.godmode.components.window.set_dragged(this);
					e.data.win.attr('drag', true);
					e.data.win.focus();
					this.get_el('border').addClass('drag');
				};


				this.stop_drag = function(e)
				{
					this.drag_reposition(e.pageX, e.pageY);
					this.attr('drag', false);
					this.get_el('border').removeClass('drag');
					drag_last_cursor_pos = null;
				};


				this.reposition = function(x, y)
				{
					this.attr("position", {"x":x, "y":y});
					this.get_el('border').css({"left":x + 'px', "top":y + 'px'});
					pwf.godmode.components.viewport.resize();
					return this;
				};


				this.drag_reposition = function(cursor_x, cursor_y)
				{
					if (drag_last_cursor_pos === null) {
						drag_last_cursor_pos = {"x":parseInt(cursor_x), "y":cursor_y = parseInt(cursor_y)};

					} else {
						var cursor_x = parseInt(cursor_x), cursor_y = parseInt(cursor_y);
						var pos = this.get_el('border').offset();
						var cursor_offset_x = drag_last_cursor_pos.x - pos.left;
						var cursor_offset_y = drag_last_cursor_pos.y - pos.top;
						var pos = {
							"x":cursor_x - cursor_offset_x,
							"y":cursor_y - cursor_offset_y
						};

						if (pos.x < 0) pos.x = 0;
						if (pos.y < 0) pos.y = 0;
						this.reposition(pos.x, pos.y);

						drag_last_cursor_pos.x = cursor_x;
						drag_last_cursor_pos.y = cursor_y;
					}
				};


				this.close = function()
				{
					this.get_el('border').remove();
					pwf.godmode.components.app_drawer.destroy_window(this.attr('id'));
					pwf.godmode.components.window.destroy(this.attr('id'));
				};


				this.switch_minimalization = function()
				{
					return this.attr('minimized') ? this.restore():this.minimize();
				};


				this.restore = function()
				{
					this.attr('minimized', false);
					this.get_el('border').show();
					pwf.godmode.components.app_drawer.update_window(this.attr('id'));
					return this;
				};


				this.minimize = function()
				{
					this.attr('minimized', true);
					this.get_el('border').hide();
					pwf.godmode.components.app_drawer.update_window(this.attr('id'));
					return this;
				};


				this.roll = function()
				{
					return this.attr('rolled_up') ? this.roll_down():this.roll_up();
				};


				this.roll_up = function()
				{
					this.get_el('content').slideUp();
					this.get_el('border').addClass('rolled_up');
					this.attr('rolled_up', true);
					pwf.godmode.components.app_drawer.update_window(this.attr('id'));
					return this;
				};


				this.roll_down = function()
				{
					this.get_el('content').slideDown();
					this.get_el('border').removeClass('rolled_up');
					this.attr('rolled_up', false);
					pwf.godmode.components.app_drawer.update_window(this.attr('id'));
					return this;
				};


				this.switch_maximization = function()
				{
					return this.attr('maximized') ? this.maximize_restore():this.maximize();
				};


				this.maximize = function()
				{
					var size = pwf.godmode.components.viewport.get_max_size();
					this.attr('position_restore', this.attr('position'));
					this.attr('size_restore', this.attr('size'));
					this.reposition(43, 21);
					this.resize(size.x, size.y);
					this.attr('maximized', true);
					return this;
				};


				this.maximize_restore = function()
				{
					var position = this.attr('position_restore');
					var size = this.attr('size_restore');

					this.reposition(position.x, position.y);
					this.resize(size.x, size.y);
					this.attr('maximized', false);
					return this;
				};


				this.load_content = function()
				{
					var url;

					if ((url = this.attr("url")).length > 0) {
						this.load_content_from(url);
					}
				};


				this.load_content_from = function(url)
				{
					this.show_preloader();

					$.ajax({
						"url":url,
						"context":this,
						"complete":function() {
							this.hide_preloader();
						},
						"success":function(data, textStatus, jqXHR) {
							var html = data;

							if (html.indexOf('<body>') > -1) {
								html = html.substr(html.indexOf('<body>'));
								html = html.substr(0, html.indexOf('</body>'));
							}

							this.attr('url', url);
							this.set_content(html);
						},

					});
				};


				this.set_content = function(html)
				{
					if (typeof html != 'undefined' && html.length > 0) {
						var h;
						this.get_el('content').html(html);

						(h = this.get_el('content').find('h1')).length >= 1 ||
						(h = this.get_el('content').find('h2')).length >= 1;
						h && this.title(h.html());

						this.set_callbacks();
						this.update_menu();
						pwf.godmode.components.window_form.bind(this);
						pwf.search_tool.init(this.get_el('content'));
						pwf.datetime_picker.scan(this.get_el('content'));
						pwf.gps.scan(this.get_el('content'));

						if (this.attr('resize_to_fit')) {
							this
								.resize_to_fit()
								.resize_to_fit()
								.attr('resize_to_fit', false);
						}
					} else throw "Cannot set window content to be empty. Use clear_content()";

					return this;
				};


				this.clear_content = function()
				{
					this.get_el('content').html('');
					return this;
				};


				this.update_menu = function()
				{
					var items = this.get_el('content').find('.window-content-menu a');

					for (var i = 0; i<items.length; i++) {
						var el = $(items[i]);

						el.attr('href') == this.attr('url') ?
							el.parent().addClass('active'):el.parent().removeClass('active');
					}
				};


				this.set_callbacks = function()
				{
					var els_body = this.get_el('content').find('.window-content-inner a');
					var els = this.get_el('content').find('.window-content-menu .menu-panel li');

					for (var i = 0; i<els.length; i++) {
						var el = $(els[i]);
						var link = el.find('a');
						var has_gm_callback = false

						for (var j = 0; j<window_ctrls.length; j++) {
							if (el.hasClass(window_ctrls[j].selector)) {
								has_gm_callback = true;
								link
									.unbind('click.godmode')
									.bind('click.godmode', {"win":this}, window_ctrls[j].callback);
								break;
							}
						}

						if (!has_gm_callback) {
							this.bind_link_to_window(link);
						}
					}

					for (var i = 0; i < els_body.length; i++) {
						var el = $(els_body[i]);

						if (!el.hasClass('gm_nobind')) {
							this.bind_link_to_window(el);
						}
					}
				};


				this.bind_link_to_window = function(jq_link)
				{
					jq_link.unbind('click.godmode').bind('click.godmode', {"win":this}, function(e) {
						e.preventDefault();
						e.data.win.load_content_from($(this).attr('href'));
					});
				};


				this.hide_preloader = function()
				{
					this.get_el('preloader').fadeOut(200);
				};


				this.show_preloader = function()
				{
					this.get_el('preloader').fadeIn(200);
				};


				this.refresh = function()
				{
					this.load_content();
				};


				this.get_content_ref = function()
				{
					return this.get_el('content');
				};
			};


		this.init = function()
		{
			$('body').bind("mouseup", {"win_ctrl":this}, function(e) { e.data.win_ctrl.undrag(e); });
			return ready = true;
		};


		this.unfocus_all = function()
		{
			for (var i = 0; i<windows.length; i++) {
				if (typeof windows[i] === 'object' && windows[i] !== null) {
					windows[i].unfocus();
				}
			}
		};


		this.set_active = function(win)
		{
			window_active = win;
		};


		this.set_dragged = function(win)
		{
			window_drag = win.attr('id');
		};


		this.create = function(data)
		{
			data.id = windows.length + 1;

			if (typeof data.position == 'undefined') {
				data.position = {"x":63, "y":41};
			}

			var win = new class_window(data);
			windows.push(win)
			win.create().show();

			return win;
		};


		this.get_active = function()
		{
			return window_active;
		};


		this.undrag = function(e)
		{
			pwf.godmode.components.viewport.get_el().unbind('mousemove.godmode_window');

			if (typeof window_drag === null) {
				for (var i = 0; i<windows.length; i++) {
					windows[i].stop_drag(e);
				}
			} else if (typeof windows[window_drag-1] === 'object') {
				windows[window_drag-1].stop_drag(e);
			}

			window_drag = null;
		};


		this.destroy = function(id)
		{
			var win = this.get_win(id-1);

			if (win !== null) {
				if (win.is_active()) {
					window_active = null;
				}

				delete win;
				windows[id-1] = null;
			}

			filter_windows(windows);
			if (typeof pwf.godmode.components.session != 'undefined') {
				pwf.godmode.components.session.drop_window(id-1);
			}
		};


		var filter_windows = function(arr, func)
		{
			var retObj = {}, k, res;

			func = func || function (v) {return v;};

			for (k in arr) {
				res = func(arr[k]);
				if (res && res !== null) {
					retObj[k] = arr[k];
				}
			}

			return retObj;
		};


		this.get_win = function(id)
		{
			return typeof windows[id] == 'object' ? windows[id]:null;
		};


		this.get_all_windows = function()
		{
			return windows;
		};


		this.is_ready = function()
		{
			return ready;
		};
	});
});
