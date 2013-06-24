pwf.register('reporter', function()
{
	var
		selectors        = ['.reporter'],
		selector_bound   = 'bound',
		selector_loader  = 'loading',
		selector_status  = 'status',
		selector_text    = 'text',
		selector_content = 'active',
		selector_root    = 'html',
		url_status       = '/user/status/',
		url_detail       = '/user/status/detail.json/',
		url_user_avatar  = '/profile/{id}/avatar/?size=40x40',
		url_team_logo    = '/teams/{id}/logo/?size=40x40',
		time_check       = 8000,
		time_fade        = 200,
		time_glow        = 1000,
		before_init      = true;


	this.init = function()
	{
		var ready = this.is_ready();

		if (ready && before_init) {
			this.scan();
			before_init = false;
		}

		return ready;
	};


	this.is_ready = function()
	{
		return $.isReady;
	};


	this.scan = function(el)
	{
		var els = typeof el === 'undefined' ? $(get_selectors()):el.find(get_selectors());
		for (var i = 0; i < els.length; i++) {
			this.bind($(els[i]));
		}
	};


	var get_selectors = function()
	{
		return selectors.join(', ');
	};


	this.bind = function(el)
	{
		if (!el.hasClass(selector_bound)) {
			var obj = {
				"container":el,
				"icon":$('<div class="reporter-icon"/>'),
				"state":$('<div class="' + selector_status + '"/>'),
				"text":$('<div class="' + selector_text + '"/>'),
				"menu":null,
				"checking":false,
				"loading":false,
				"timer":null,
				"request":null,
				"data":null,
				"glow":false,
				"glower":null,
				"updated_at":null,
				"status":{
					"requests":0,
					"notices":0,
					"updated_at":null
				}
			};

			obj.container.append(obj.icon);
			obj.icon.append([obj.state, obj.text]);
			obj.icon.bind('click.reporter', obj, callback_open);

			start_checks_for(obj, true);
			el.addClass(selector_bound);
		}
	};


	var callback_open = function(e)
	{
		e.stopPropagation();
		e.preventDefault();
		stop_checks_for(e.data);
		stop_glow(e.data);

		if (!e.data.loading && e.data.menu === null) {
			e.data.icon.unbind('click.reporter');
			$(selector_root).bind('click.reporter', e.data, callback_close);

			if (e.data.status.requests + e.data.status.notices > 0) {
				e.data.container.addClass(selector_loader);
				e.data.loading = true;
				$.ajax({
					"url":url_detail,
					"dataType":"json",
					"context":e.data,
					"complete":callback_detail_done,
					"success":callback_detail_success,
				});
			} else callback_detail_empty(e.data);
		}
	};


	var callback_close = function(e)
	{
		e.stopPropagation();
		e.preventDefault();

		$(selector_root).unbind('click.reporter');
		start_checks_for(e.data, true);
		e.data.menu.remove();
		e.data.menu = null;
		e.data.icon.bind('click.reporter', e.data, callback_open);
	};


	var callback_detail_done = function()
	{
		this.loading = false;
		this.container.removeClass(selector_loader);
	};


	var callback_detail_empty = function(obj)
	{
		var inner = $('<ul class="plain"></ul>');
		var row = $('<li></li>');
		var avatar  = $('<div class="avatar"><img src="/share/icons/40/impro/status/empty" alt=""></div>');
		var content = $('<div class="content">Nemám pro vás žádná nová upozornění. Nebojte, hlídám.<br>Kliknutím zavřete.</div>');

		obj.menu = $('<div class="reporter-menu"/>');
		obj.menu.append(inner.append(row.append([avatar, content])));
		obj.container.append(obj.menu);
	};


	var callback_detail_success = function(response)
	{
		var objects = [];

		for (var i = 0; i < response.requests.length; i++) {
			objects.push(response.requests[i]);
		}

		for (var i = 0; i < response.notices.length; i++) {
			objects.push(response.notices[i]);
		}

		objects.sort(sort_helper);

		this.menu = $('<div class="reporter-menu"/>');
		var inner = $('<ul class="plain"/>');

		for (var i = 0; i < objects.length; i++) {
			var row = $('<li/>');
			var avatar  = $('<div class="avatar"/>');
			var content = $('<div class="content"/>');
			var url = '';

			if (objects[i].team) {
				url = url_team_logo.replace('{id}', objects[i].team);
			} else {
				url = url_user_avatar.replace('{id}', objects[i].author);
			}

			avatar.html('<img src="' + url + '" alt="" />');
			content.html(objects[i].text);
			row.addClass(i%2?'odd':'even').append([avatar, content]);
			row.bind('click', objects[i], callback_menu_link);
			inner.append(row);
		}

		this.container.append(this.menu.append(inner).hide());
		this.menu.fadeIn(time_fade);
	};

	var sort_helper = function(l, r)
	{
		if (l.created_at > r.created_at) return 1;
		if (l.created_at < r.created_at) return -1;
		return 0;
	};


	var callback_menu_link = function(e)
	{
		e.stopPropagation();
		e.preventDefault();

		document.location = e.data.link;
	};


	var start_checks_for = function(obj, initial)
	{
		var initial = typeof initial === 'undefined' ? false:!!initial;
		obj.checking = true;

		if (initial) {
			check_for(obj);
		} else {
			set_check_for(obj);
		}
	};


	var set_check_for = function(obj)
	{
		if (obj.timer === null) {
			obj.timer = setTimeout(function(obj) {
				return function() {
					check_for(obj);
				};
			}(obj), time_check);
		}
	};


	var stop_checks_for = function(obj)
	{
		if (obj.request !== null) {
			obj.request.abort();
		}

		clearTimeout(obj.timer);
		obj.checking = false;
		obj.timer = null;
	};


	var check_for = function(obj)
	{
		if (obj.request === null) {
			obj.container.addClass(selector_loader);
			obj.request = $.ajax({
				"url":url_status,
				"context":obj,
				"dataType":"json",
				"success":callback_check_success,
				"complete":callback_check_done
			});
		}
	};


	var callback_check_success = function(response)
	{
		this.status.requests   = parseInt(response['requests']);
		this.status.notices    = parseInt(response['notices']);
		this.status.updated_at = parseInt(response['updated_at']);

		update_status(this);
	};


	var callback_check_done = function()
	{
		this.timer = null;
		this.request = null;
		this.container.removeClass(selector_loader);

		if (this.checking) {
			set_check_for(this);
		}
	};


	var update_status = function(obj)
	{
		var total = obj.status.requests + obj.status.notices;
		var text = '';

		if (total > 0) {
			var str = 'nových upozornění';
			if (total < 5) str = 'nové upozornění';
			text = total + ' ' + str;
		} else {
			text = 'žádná upozornění';
		}

		obj.text.html(text);

		if (total > 0) {
			start_glow(obj);
			obj.container.addClass(selector_content);
		} else {
			stop_glow(obj);
			obj.container.removeClass(selector_content);
		}
	};


	var start_glow = function(obj)
	{
		if (!obj.glow) {
			obj.glow = true;
			glow(obj);
		}
	};


	var stop_glow = function(obj)
	{
		obj.glow = false;
		obj.glower = clearTimeout(obj.glower);
		obj.state.stop(true, true).css('opacity', 1);
	};


	var glow = function(obj)
	{
		obj.state.animate({"opacity":.5}, time_glow, function(obj) {
			return function() {
				if (obj.glow) {
					obj.glower = setTimeout(function(obj) {
						return function() {
							obj.state.animate({"opacity":1}, time_glow, function(obj) {
								return function() {
									if (obj.glow) {
										glow(obj);
									}
								};
							}(obj));
						};
					}(obj), time_fade);
				}
			};
		}(obj));
	};
});
