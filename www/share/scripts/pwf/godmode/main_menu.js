pwf.register('main_menu', function()
{
	var
		self = this,
		opened = false,
		els = {
			"container":null
		},
		ready = false;


	this.init = function()
	{
		if (this.is_ready()) {
			create();
			return true;
		}

		return false;
	};


	this.is_ready = function()
	{
		return typeof pwf_main_menu != 'undefined' && $.isReady;
	};


	this.get_el = function(name)
	{
		return typeof els[name] == 'undefined' ? null:els[name];
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
			var icon  = $(pwf.icon.html('godmode/'+data[i].icon, 16));
			var label = $('<span class="label">'+data[i].name+'</span>');
			name.append(icon);
			name.append(label);
			category.append(name);

			if (typeof data[i].url != 'undefined' && data[i].url !== null) {
				name.attr('href', data[i].url);
				name.bind('click', {"title":data[i].name, "url":data[i].url, "icon":data[i].icon}, function(e) {
					e.preventDefault();
					e.stopPropagation();

					pwf.main_menu.close();
					pwf.window.create({
						"title":e.data.title,
						"url":e.data.url,
						"icon":"godmode/" + e.data.icon,
					});
				});
			} else {
				name.bind('click', function(e) {
					e.stopPropagation();
					e.preventDefault();
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
		opened = true;
	};


	this.close = function()
	{
		this.get_el('container').hide();
		opened = false;
	};


	this.open_close = function()
	{
		return opened ? this.close():this.open();
	};
});
