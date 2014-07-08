pwf.register('site', function() {
	var
		ui,
		viewport,
		loader,
		menu,
		user,

		models = ['System::User', 'Impro::News', 'Impro::Event', 'Impro::Team', 'Impro::Article', 'Impro::Media::Article'],
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

				user = pwf.model.create('System::User', pwf.config.get('user'));

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
		menu = pwf.create('ui.intra.menu', {
			'parent':pwf.jquery('body')
		});

		pwf.jquery(window)
			.bind('navigate', this, callback_navigate)
			.bind('resize',   this, callback_resize)
			.bind('scroll',   this, callback_update_menu)
			.bind('loading',  this, callback_loader_show)
			.bind('ready',    this, callback_loader_hide);

		return this;
	};


	this.resize = function()
	{
		var
			win    = pwf.jquery(window),
			height = win.height();

		menu.resize();
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


	this.get_user = function()
	{
		return user;
	};


	var callback_resize = function(e)
	{
		e.data.resize();
	};


	var callback_update_menu = function(e)
	{
		e.data.update_menu();
		e.data.resize();
	};


	var callback_history = function(e)
	{
		var
			el    = pwf.jquery(this),
			title = el.attr('title');

		e.preventDefault();
		pwf.site.navigate(el.attr('href'), title);
	};


	var callback_navigate = function(e, rq)
	{
		e.data.navigate(rq.url, rq.title);
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
