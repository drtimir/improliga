pwf.register('site', function() {
	var
		ui,
		viewport,
		loader,
		menu,
		user,

		models = [
			'System::User',
			'Impro::User::Alert',
			'Impro::News',
			'Impro::Event',
			'Impro::Team',
			'Impro::Article',
			'Impro::Media::Article'
		],

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
				user = pwf.model.create('System::User', pwf.config.get('user'));
				next();
			},

			function(next) {
				pwf.create('model.list', {
					'model':'Impro::Team::Member',
					'filters':[
						{'attr':'id_system_user', 'type':'exact', 'exact':user.get('id')}
					]
				}).load(function(err, list) {
					next(err);
					user.set('roles', list.data);
				});
			},

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


	this.get_user_name = function(user)
	{
		var str = '';

		if (typeof user == 'undefined') {
			user = this.get_user();
		}

		if (user.get('nick')) {
			str = user.get('nick');
		} else {
			str = [user.get('name_first'), user.get('name_last')].join(' ');
		}

		if (!str || str == ' ') {
			str = user.get('login');
		}

		if (!str) {
			str = user.get('id');
		}

		return str;
	};


	this.get_user_avatar = function()
	{
		var avatar;

		if (typeof user == 'undefined') {
			user = this.get_user();
		}

		avatar = user.get('avatar');

		if (!avatar) {
			avatar = {
				'path':'share/pixmaps/pwf/anonymous_user.png',
				'url':'<pixmap(pwf/anonymous_user.png)>'
			};
		}

		return avatar;
	};


	this.is_user_member = function(team, role)
	{
		var
			roles = user.get('roles'),
			team  = typeof team == 'number' ? team:team.get('id');

		for (var i = 0, len = roles.length; i < len; i++) {
			var
				role_team = roles[i].get('team'),
				in_team = role_team === team || (role_team instanceof Object && roles[i].get('team').get('id') == team),
				in_role = roles[i].get('roles').indexOf(role) >= 0;

			if (in_team && in_role) {
				return true;
			}

			if (typeof role == 'undefined' && in_team) {
				return true;
			}
		}

		return false;
	};


	this.is_user_member_in = function(team, roles)
	{
		for (var i = 0, len = roles.length; i < len; i++) {
			if (this.is_user_member(team, roles[i])) {
				return true;
			}
		}

		return false;
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
