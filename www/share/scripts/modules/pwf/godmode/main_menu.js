$(function() {
	pwf.godmode.register('main_menu', function()
	{
		var
			self = this,
			attrs = {
				"opened":false,
			},
			els = {
				"container":null
			},
			ready = false;


		this.init = function()
		{
			if (this.exists()) {
				create();
				return ready = true;
			}

			return false;
		};


		this.exists = function()
		{
			return typeof pwf_main_menu != 'undefined';
		};


		this.is_ready = function()
		{
			return ready;
		};


		this.get_el = function(name)
		{
			return typeof els[name] == 'undefined' ? null:els[name];
		};


		this.attr = function(attr, value)
		{
			if (typeof attrs[attr] != 'undefined') {
				if (typeof value != 'undefined') {
					attrs[attr] = value;
				}

				return attrs[attr];
			} else throw "Attribute "+attr+" does not exist for main menu";
		};


		var create = function()
		{
			create_container();
			create_items();
			$('body').append(self.get_el('container'));
		};


		var create_container = function()
		{
			if (self.get_el('container') === null) {
				els.container = $('<menu class="main_menu"></menu>');
			}
		};


		var create_items = function()
		{
			create_items_recursive(pwf_main_menu, els.container);
		};


		var create_items_recursive = function(data, items_container)
		{
			for (var i = 0; i<data.length; i++) {
				var category = $('<li></li>');
				var name  = $('<a class="name" href=""></a>');
				var icon  = $('<span class="icon"></span>');
				var label = $('<span class="label">'+data[i].name+'</span>');
				name.append(icon);
				name.append(label);
				category.append(name);

				if (typeof data[i].url != 'undefined') {
					name.attr('href', data[i].url);
					name.bind('click', {"title":data[i].name, "url":data[i].url}, function(e) {
						e.preventDefault();
						e.stopPropagation();

						pwf.godmode.components.main_menu.close();
						pwf.godmode.components.window.create({
							"title":e.data.title,
							"url":e.data.url
						});
					});
				}

				if (typeof data[i].items != 'undefined' && data[i].items.length > 0) {

					var menu = $('<menu class="submenu"></menu>');
					create_items_recursive(data[i].items, menu);
					category.append(menu);

				}

				items_container.append(category);
			}
		};


		this.open = function()
		{
			this.get_el('container').show();
			this.attr('opened', true);
		};


		this.close = function()
		{
			this.get_el('container').hide();
			this.attr('opened', false);
		};


		this.open_close = function()
		{
			return this.attr('opened') ? this.close():this.open();
		};
	});
});
