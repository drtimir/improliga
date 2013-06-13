pwf.register('relman', function()
{
	var
		selectors = [".editor .relman"],
		marker = 'bound',
		selector_drop = '.relman_drop',
		selector_add_button = '.relman-add-button',
		selector_drop_button = '.relman-drop-button',

		class_relman_item = function(el)
		{
			var el = el;
			this.id = get_item_el_id(el);


			this.el = function()
			{
				return el;
			};


			this.drop = function()
			{
				var check = null;

				if (this.id) {
					if ((check = el.find(selector_drop)).length) {
						check.click();
					}

					var button = this.el().find(selector_drop_button);
					button
						.html('')
						.unbind('click')
						.append(pwf.godmode.components.icon.html('godmode/window/refresh', 16))
						.append(pwf.godmode.trans('godmode_return_back'))
						.bind('click', this, callback_item_return);
				}

				el.animate({"height":35}, function(obj) {
					return function() {
						if (obj.id === null) {
							obj.el().remove();
						}
					};
				}(this));
			};


			this.return_back = function()
			{
				if (this.id) {
					this.el().css('height', 'auto');
					el.find(selector_drop).click();
					this.el().find(selector_drop_button).remove();
					add_relman_drop_button(this);
				}
			};

			add_relman_drop_button(this);
		},

		class_relman = function(el)
		{
			this.objects = get_relman_items(el);

			var
				el = el,
				empty = create_empty(this),
				empty_num = empty.num,
				empty_new_num = empty.num;


			this.add = function()
			{
				var regex = new RegExp('(\\\[' + empty_num + '\\\])', 'g');
				var new_empty = empty.clone();
				var new_num = empty_new_num + 1;
				var new_html = new_empty.html().replace(regex, '[' + new_num + ']');

				empty_new_num = new_num;
				new_empty.html(new_html);

				this.el().find('.tab_content').append(new_empty);
				this.objects.push(new class_relman_item(new_empty));
			};


			this.el = function()
			{
				return el;
			};

			this.object

			add_relman_add_button(this);
		};


	this.init = function()
	{
		var ready = this.is_ready();

		if (ready) {
			this.scan();
		}

		return ready;
	};


	this.is_ready = function()
	{
		return $.isReady;
	};


	this.scan = function(container)
	{
		var els = typeof container === 'undefined' ? $(selectors.join(', ')):container.find(selectors.join(', '))

		for (var i = 0; i < els.length; i++) {
			var el = $(els[i]);

			if (!el.hasClass(marker)) {
				this.bind(el);
				el.addClass(marker);
			}
		}
	};


	this.bind = function(el)
	{
		return new class_relman(el);
	};


	var get_relman_items = function(el)
	{
		var items = [];
		var fieldsets = el.find('fieldset.relman_object');

		for (var i = 0; i < fieldsets.length; i++) {
			items.push(new class_relman_item($(fieldsets[i])));
		}

		return items;
	};


	var get_item_el_id = function(el)
	{
		var classes = el.attr('class').split(' ');

		for (var i = 0; i < classes.length; i++) {
			if (classes[i].match(/^relman_object_([0-9]+)$/)) {
				return parseInt(classes[i].substr(14));
			}
		}

		return null;
	};


	var add_relman_add_button = function(obj)
	{
		var button = $('<a href="#" class="' + selector_add_button.substr(1) + '"/>');
		var button_label = '<span class="text">' + pwf.godmode.trans('godmode_add_another') + '</span>';
		var check  = obj.el().find(selector_drop);
		var ctrl   = $('<div class="relman-controls"/>');

		check.parents('li').hide();
		button.append(pwf.godmode.components.icon.html('godmode/actions/create', 16));
		button.append(button_label);
		button.bind('click', obj, callback_item_add);
		obj.el().append(ctrl.append(button));
	};


	var add_relman_drop_button = function(obj)
	{
		var button = $('<a href="#" class="' + selector_drop_button.substr(1) + '"/>');
		var button_label = '<span class="text">' + pwf.godmode.trans('godmode_delete') + '</span>';
		var check  = obj.el().find(selector_drop);

		check.parents('li').hide();
		button.append(pwf.godmode.components.icon.html('godmode/actions/delete', 16));
		button.append(button_label);
		button.bind('click', obj, callback_item_drop);
		obj.el().append(button);
	};


	var create_empty = function(obj)
	{
		var empty = obj.objects[obj.objects.length - 1].el().clone();
		var classes = empty.attr('class').split(' ');
		var num = 0;

		for (var i = 0; i < classes.length; i++) {
			if (classes[i].match(/^relman_object_add_([0-9]+)$/)) {
				num = parseInt(classes[i].substr('relman_object_add_'.length));
			}
		}

		empty.find(selector_drop_button).remove();

		empty.num = num;
		return empty;
	};


	var callback_item_drop = function(e)
	{
		e.stopPropagation();
		e.preventDefault();
		e.data.drop();
	};


	var callback_item_return = function(e)
	{
		e.stopPropagation();
		e.preventDefault();
		e.data.return_back();
	};


	var callback_item_add = function(e)
	{
		e.stopPropagation();
		e.preventDefault();
		e.data.add();
	};
});
