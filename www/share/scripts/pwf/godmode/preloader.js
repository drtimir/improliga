pwf.register('preloader', function()
{
	var
		element = null,
		loaded = false,
		self = this,
		els = {},
		done = false,
		ready = false,
		special_resources = [];

	this.resources = [];


	this.init = function()
	{
		if (this.is_ready()) {
			create();
			pwf.preloader.preload();
			return ready = true;
		}

		return ready;
	};


	this.is_ready = function()
	{
		return $.isReady;
	};


	this.show = function()
	{
		element.fadeIn(150);
	};


	this.hide = function(name)
	{
		element.fadeOut(150);
	};


	this.el = function(name, obj)
	{
		if (typeof obj === 'object') {
			els[name] = obj;
		}

		return typeof els[name] === 'undefined' ? null:els[name];
	};


	this.exists = function()
	{
		return true;
	};


	var create = function()
	{
		if (element === null) {
			element = $('<div class="godmode_preloader"></div>');
			$('body').append(element);
		}

		if (self.el('inner') === null) {
			self.el('inner', $('<div class="inner"></div>'));
			self.el('label', $('<div class="label"></div>'));
			self.el('label_text', $('<span class="text">Loading godmode</span>'));
			self.el('label_progress', $('<span class="progress_text"></span>'));
			self.el('progress_outer', $('<div class="progress_outer"></div>'));
			self.el('progress', $('<div class="progress"></div>'));

			element.append(self.el('inner'));
			element.append(self.el('label_progress'));
			self.el('inner').append(self.el('label'));
			self.el('inner').append(self.el('progress_outer'));

			self.el('label').append(self.el('label_text'));
			self.el('progress_outer').append(self.el('progress'));
		}
	};


	this.gather_resources = function()
	{
		this.resources = [];

		for (var i = 0; i<special_resources.length; i++) {
			pwf.preloader.add_resource(this, special_resources[i].type, special_resources[i].src);
		}

		pwf.preloader.include_images_from_styles(this);

		for (var i = 0; i<pwf_icons.length; i++) {
			pwf.preloader.add_resource(this, 'image', pwf_icons[i]);
		}

		return this.resources;
	};


	this.preload = function()
	{
		this.init();
		pwf.preloader.preload_with(this);
	};


	this.ready = function()
	{
		this.hide();
		done = true;
	};


	this.is_done = function()
	{
		return done;
	};
});
