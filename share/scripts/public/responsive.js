pwf.register('responsive', function()
{
	this.is_ready = function()
	{
		return pwf.mi(['jquery']);
	};


	this.init = function()
	{
		pwf.jquery(window).bind('resize', this, callback_reset);

		this
			.init_paralax()
			.reset()
			.init_anchors();
	};


	this.init_paralax = function()
	{
		var
			lax = pwf.jquery('.paralax');
			ilax = lax.find('.paralax-inner'),
			boxes = ilax.children('.template'),
			menu = pwf.jquery('.main-menu'),
			mitems = menu.find('a');

		boxes.wrap('<div class="lax-body"/>');
		boxes.wrap('<div class="lax-body-inner"/>');

		for (var i = 0; i < boxes.length; i++) {
			var
				bg = pwf.jquery.div('bg max'),
				img = pwf.jquery('<img/>').attr('src', '/share/pixmaps/public/bg.jpg').attr('alt', 'background');

			bg.append(img).insertBefore(boxes[i].parentNode);
		}

		for (var i = 0; i < mitems.length; i++) {
			var
				item = pwf.jquery(mitems[i]),
				href = item.attr('href').replace(/^\//, '');

			item.attr('href', '#!' + href);

			if (typeof boxes[i] != 'undefined') {
				var
					box = pwf.jquery(boxes[i]),
					p = box.parents('.lax-body').first();

				p.attr('id', href);
			}
		}

		return this;
	};


	this.init_anchors = function()
	{
		pwf.jquery(window).bind('hashchange', this, callback_hashchange);
		pwf.jquery('.sections').bind('scroll', this, callback_scroll);

		return this.scroll_to_hash();
	};


	this.scroll_to = function(el)
	{
		var
			top = el.position().top - pwf.jquery('.paralax').position().top,
			sec = pwf.jquery('.sections');

		sec.stop(true).animate({
			'scrollTop':top
		});
	};


	this.get_el_from_hash = function(hash)
	{
		var
			hash = hash.substr(2),
			ilax = pwf.jquery('.paralax-inner'),
			el;

		return hash ?
			ilax.children('#' + hash):
			ilax.children().first();

		return el;
	};


	this.scroll_to_hash = function()
	{
		var el = this.get_el_from_hash(document.location.hash);

		if (el.length) {
			this.scroll_to(el);
		}

		return this;
	};


	this.update_menu = function(e)
	{
		var
			sec = pwf.jquery('.sections'),
			lax = pwf.jquery('.paralax'),
			els = pwf.jquery('.main-menu a'),
			sel = null,
			top = lax.height();

		for (var i = 0; i < els.length; i++) {
			var
				item = pwf.jquery(els[i]),
				el = this.get_el_from_hash(item.attr('href')),
				et = el.position().top;

			item.removeClass('active');

			if (et >= 0 && sel === null) {
				sel = item;
				top = et;
			}
		}

		if (sel !== null) {
			sel.addClass('active');
		}

		return this;
	};


	this.reset = function()
	{
		var
			win = pwf.jquery(window),
			horizontal = win.height() > win.width(),
			bg  = pwf.jquery('.bg'),
			img = bg.find('img'),
			content = pwf.jquery('#content'),
			lax = pwf.jquery('.paralax'),
			ilax = lax.find('.paralax-inner'),
			boxes = ilax.children('.template'),
			center = ilax.find('.system-text-show');

		if (horizontal) {
			img.css({'width':bg.height()});
		} else {
			img.css({'width':bg.width()});
		}

		ilax.children('.lax-body').height(win.height() - 80);

		for (var i = 0; i < center.length; i++) {
			var
				c = pwf.jquery(center[i]),
				p = c.parents('.lax-body-inner');

			c.css({
				'position':'absolute',
				'left':Math.round((p.width() - c.width())/2),
				'top':Math.round((p.height() - c.height())/2),
			});
		}

		content.css({'left':Math.max(0, Math.round((win.width() - content.width())/2))});
		img.css({
			'left':Math.round((bg.width() - img.width())/2),
			'top':Math.round((bg.height() - img.height())/2),
		});

		return this;
	};


	var callback_reset = function(e)
	{
		e.data.reset();
	};


	var callback_hashchange = function(e)
	{
		e.data.scroll_to_hash();
	};


	var callback_scroll = function(e)
	{
		e.data.update_menu();
	};
});
