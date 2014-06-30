pwf.register('site', function() {
	var
		ui,
		viewport,
		loader,

		models = ['Impro::Event', 'Impro::Team', 'Impro::Article'],
		resources = {
			'essential':[],
			'editor':[]
		};


	this.is_ready = function()
	{
		return pwf.mi(['config', 'jquery', 'locales', 'dispatcher']);
	};


	this.init = function()
	{
		ui = pwf.jquery('#ui').create_divs(['preloader']);
		viewport = pwf.jquery('#viewport');

		var jobs = [

			function(next) {
				pwf.preload(resources.essential, next);
			},

			function(next) {
				pwf.locales.preload(next);
			},

			function(ctrl) {
				return function(next) {
					ctrl.bind().load(next);
				};
			}(this),

			function(next) {
				pwf.dispatcher.reload(next);
			}
		];

		pwf.async.waterfall(jobs, function(ctrl) {
			return function(err) {
				if (loader) {
					loader.hide();
				}

				v('done', err);
			}
		}(this));
	};


	this.load = function(next)
	{
		var res = resources.editor.slice(0);

		for  (var i = 0; i < models.length; i++) {
			res.push({
				'type':'schema',
				'model':models[i]
			});
		}

		loader = pwf.create('ui.loader', {
				'parent':pwf.jquery('body'),
				'use_styles':true,
				'resources':res
			});

		loader.display().preload(next);
	};


	this.get_el = function()
	{
		return viewport;
	};


	this.bind = function()
	{
		pwf.jquery('#main-menu').first().find('a').bind('click', callback_history);
		pwf.jquery(window)
			.bind('resize',  this, callback_resize)
			.bind('scroll',  this, callback_update_menu)
			.bind('loading', this, callback_loader_show)
			.bind('ready',   this, callback_loader_hide);

		return this;
	};


	this.resize = function()
	{
		var
			win      = pwf.jquery(window),
			height   = win.height(),
			root     = viewport.children('.ui-structure-section'),
			children = root.children('.section-inner').children('.ui-structure-section');

		children.height(height);

		return this
			.center_all(children.find('.section-inner').children())
			.center_all(root.children('.section-inner').children());
	};


	this.center_all = function(list)
	{
		var
			win    = pwf.jquery(window),
			height = win.height();

		for (var i = 0; i < list.length; i++) {
			var item = pwf.jquery(list[i]);

			item.css('top', Math.round((height - item.outerHeight())/2));
		}

		return this;
	};


	this.update_menu = function()
	{
		var
			page = pwf.dispatcher.get_current(),
			cont = page.get('content');

		if (typeof cont.update_menu == 'function') {
			cont.update_menu();
		}
	};


	this.navigate = function(url, title)
	{
		if (!title) {
			title = document.title;
		}

		History.pushState(null, title, url);
		return this;
	};


	this.loader_show = function()
	{
		ui.preloader.stop(true).fadeIn(250);
		return this;
	};


	this.loader_hide = function()
	{
		ui.preloader.stop(true).fadeOut(250);
		return this;
	};


	var callback_resize = function(e)
	{
		e.data.resize();
	};


	var callback_update_menu = function(e)
	{
		e.data.update_menu();
	};


	var callback_history = function(e)
	{
		var
			el    = pwf.jquery(this),
			title = el.attr('title');

		e.preventDefault();
		pwf.site.navigate(el.attr('href'), title);
	};


	var callback_loader_show = function(e)
	{
		e.data.loader_show();
	};


	var callback_loader_hide = function(e)
	{
		e.data.loader_hide();
	};
});
