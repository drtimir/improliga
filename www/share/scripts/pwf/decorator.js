pwf.register('decorator', function()
{
	var
		selectors = ['select', 'input[type=checkbox]', 'input[type=radio]'],
		self = this;


	this.init = function()
	{
		if (this.is_ready()) {
			this.scan();
		}

		return this.is_ready();
	};


	this.is_ready = function()
	{
		return $.isReady;
	};


	this.scan = function(container)
	{
		var els;

		if (typeof el === 'undefined') {
			els = $(this.get_selector());
		} else {
			els = container.find(this.get_selector());
		}

		for (var i = 0; i < els.length; i++) {
			var el = $(els[i]);

			if (!el.hasClass('deco')) {
				this.decorate(el);
				el.addClass('deco');
			}
		}
	};


	this.get_selector = function()
	{
		return selectors.join(', ');
	};


	this.decorate = function(el)
	{
		var type = el.attr('type');
		var cname = el.attr('class');

		if (el.is('select')) {
			type = 'select';
		}

		if (typeof this['decorate_' + type] === 'function') {
			var wrapper = this['decorate_' + type](el);

			if (typeof cname !== 'undefined' && cname !== null && cname.length) {
				wrapper.addClass(cname);
			}
		}
	};


	this.decorate_radio = function(el)
	{
		return this.decorate_checkbox(el, true);
	};


	this.decorate_checkbox = function(el, radio)
	{
		var radio   = typeof radio == 'undefined' ? false:!!radio;
		var input   = $('<div class="input"></div>');
		var wrapper;
		var context;

		el.wrap('<div class="deco-' + (radio ? 'radio':'checkbox') + '"></div>');
		wrapper = el.parent();
		wrapper.append(input);
		el.hide();

		context = {'box':el, 'deco':input, 'radio':[]};

		if (radio) {
			context['radio']= $('input[name=' + el.attr('name') + ']');
		}

		input.unbind('click.deco').bind('click.deco', context, callback_checkbox);
		input.unbind('change.deco').bind('change.deco', context, callback_checkbox);
		el.bind('change.deco', context, callback_checkbox_change);
		el.bind('click.deco', context, callback_checkbox_change);
		callback_checkbox_change({"data":context});
		return wrapper;
	};


	var callback_checkbox = function(e)
	{
		e.preventDefault();
		e.stopPropagation();

		if (e.data.box.prop('checked')) {
			e.data.box.prop('checked', false);
		} else {
			e.data.box.prop('checked', true);
		}

		callback_checkbox_change(e);
	};


	var callback_checkbox_change = function(e)
	{
		if (e.data.box.prop('checked')) {
			e.data.deco.addClass('checked');
		} else {
			e.data.deco.removeClass('checked');
		}

		if (typeof e.data.radio != 'undefined') {
			for (var i = 0; i<e.data.radio.length; i++) {
				callback_radio_change_remote($(e.data.radio[i]));
			}
		}
	};


	var callback_radio_change_remote = function(el)
	{
		var input = el.next('.input');
		callback_checkbox_change({"data":{"box":el, "deco":input}});
	};


	this.decorate_select = function(el)
	{
		var wrapper = $('<div class="deco-select"/>');
		var label   = $('<div class="label"/>');
		var current = $('<span class="current"/>');
		var button  = $('<span class="insp button"/>');
		var text    = $('<span class="text value"/>');

		wrapper.append(label.append([current, button]));
		current.append(text);
		el.parent().append(wrapper);
		wrapper.append([el]);
		el.hide();

		text.html(el.find('option:selected').html());
		this.bind_select_clickable_el(el, $([current[0], button[0], label[0]]));

		return wrapper;
	};


	this.bind_select_clickable_el = function(el, clickable)
	{
		return clickable.bind('click.deco', {"el":el, "deco":this, "clickable":clickable}, function(e) {
			e.data.deco.display_menu(e.data.el, clickable);
			e.stopPropagation();
		});
	};


	this.display_menu = function(el, clickable)
	{
		$('body').bind('click.deco', {"el":el, "deco":this, "clickable":clickable}, function(e) {
			e.data.deco.hide_menu(e.data.el, e.data.clickable);
		});

		clickable.unbind('click.deco');

		var menu = menu = $('<ul class="plain menu"></ul>');
		var select_opts = el.find('option');
		var opts = [];

		for (var i = 0; i < select_opts.length; i++) {
			var eopt = $(select_opts[i]);

			if (!eopt.hasClass('nouse')) {
				var opt  = $('<li class="val_' + eopt.attr('value') + (eopt.prop('selected') ? ' selected':'') + '"></li>');
				var text = $('<span class="text">'+(eopt.html())+'</span>');

				opt.append(text);
				opts.push(opt);
				opt.bind('click.deco', {"el":el, "deco":this, "opt":eopt, "opt_deco":text, "clickable":clickable}, callback_option);
			}
		}

		menu.hide();
		menu.append(opts);
		el.parent().append(menu);
		this.reposition_menu(el, menu);
	};


	this.update_select_text = function(el, t)
	{
		t.html(el.find('option:selected').html());
	};


	this.reposition_menu = function(el, menu)
	{
		menu.css({"display":'block', "visibility":'hidden', 'margin-top':0});

		var
			win = $(window),
			half = Math.round(win.scrollTop() + win.height()/2) + this.get_offset('y'),
			top = menu.offset().top,
			par = el.parent().offset().top - 1,
			top_from_half = Math.abs(half-top),
			par_from_half = Math.abs(half-par);

		if (top_from_half > par_from_half) {
			menu.css({"margin-top": (par - top - menu.height()) + 'px'}).addClass('top');
		}

		menu.css('visibility', 'visible').hide().fadeIn(100);
	};


	this.get_offset = function(coord)
	{
		var offsets = $('.offset-' + coord);
		var length  = 0;

		for (var i = 0; i < offsets.length; i++) {
			length += $(offsets[i]).height();
		}

		return length;
	};


	var callback_option = function(e)
	{
		e.stopPropagation();
		e.preventDefault();

		e.data.el.parent().find('.value').html(e.data.opt.html());

		var opts = e.data.el.find('option');
		for (var i = 0; i < opts.length; i++) {
			$(opts[i]).attr('selected', false).prop('selected', false);
		}

		e.data.opt.attr('selected', true).prop('selected', true).click();
		e.data.deco.hide_menu(e.data.el, e.data.clickable);
	};


	this.hide_menu = function(el, clickable)
	{
		$('body').unbind('click.deco');
		el.parent().find('.menu').fadeOut(100, function() {
			$(this).remove();
		});
		this.bind_select_clickable_el(el, clickable);
	};
});

