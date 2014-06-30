pwf.register('site', function() {
	var
		viewport,
		loader,

		models = ['Impro::Event', 'Impro::Team'],
		sections = ['ui.home', 'ui.about', 'ui.shows', 'ui.teams', 'ui.workshops', 'ui.media', 'ui.contact', 'ui.event'],

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
		viewport = pwf.jquery('#viewport');

		var jobs = [

			function(next) {
				pwf.preload(resources.essential, next);
			},

			function(ctrl) {
				return function(next) {
					ctrl.load(next);
				};
			}(this)
		];

		pwf.async.waterfall(jobs, function(ctrl) {
			return function(err) {
				loader.hide();

				if (err) {
					v('done', err);
				} else {
					pwf.dispatcher.check_anchors();
					ctrl.bind().resize();
				}
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
		pwf.jquery('body').bind('resize', this, callback_resize);
		pwf.jquery(window)
			.bind('resize', this, callback_resize)
			.bind('scroll', this, callback_update_menu);

		return this;
	};


	this.resize = function()
	{
		var
			win      = pwf.jquery(window),
			height   = win.height(),
			root     = viewport.children('.ui-structure-section'),
			children = root.children('.section-inner').children(),
			inner    = children.find('.section-inner').children();

		children.height(height);

		for (var i = 0; i < inner.length; i++) {
			var item = pwf.jquery(inner[i]);

			item.css('top', Math.round((height - item.outerHeight())/2));
		}

		return this;
	};


	this.update_menu = function()
	{
		var
			items  = pwf.jquery('#main-menu').first().find('a'),
			active = null,
			scroll = pwf.jquery('html, body').scrollTop();

		for (var i = 0; i < items.length; i++) {
			break;
			var
				item = pwf.jquery(items[i]),
				anchor = item.attr('href').substr(pwf.dispatcher.get_anchor_separator().length),
				solution = pwf.dispatcher.get_solution_for(anchor);

			item.removeClass('active');

			if (solution) {
				if (active === null) {
					var
						el  = pwf.jquery('.ui-structure-section.' + solution.get('bind')),
						off = el.offset();

					if ((off.top + el.height()/2) >= scroll) {
						active = item;
					}
				}
			}
		}

		if (active) {
			active.addClass('active');
		}
	};


	var callback_resize = function(e)
	{
		e.data.resize();
	};


	var callback_update_menu = function(e)
	{
		e.data.update_menu();
	};
});
