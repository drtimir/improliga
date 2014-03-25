pwf.register('browser_control.js', function()
{
	var min_versions = {
		"firefox":15,
		"chrome":14,
		"opera":12,
		"ie":10,
		"omniweb":0,
		"safari":0,
		"icab":0,
		"konqueror":0,
		"camino":0,
		"netscape":0,
		"mozilla":null
	};

	var browsers = [
		{"name":"Mozilla Firefox", "cname":"firefox", "url":"http://firefox.com"},
		{"name":"Google Chrome", "cname":"chrome", "url":"http://chrome.google.com"},
		{"name":"Opera", "cname":"opera", "url":"http://www.opera.com"}
	];

	var messages = {
		"en":{
			"heading":'You have ancient browser.',
			"message":'<p>You\'re using a deprecated browser <b>{browser_name} {browser_version}</b>. It is not guaranteed that this website will display correctly and it is entirely possible that it will not work at all because your browsers rendering core is too old.</p><p>Please update your browser or get a new one.</p>',
			"pass":'I want to see the website anyway.'
		},
		"cs":{
			"heading":'Váš prohlížeč je zastaralý.',
			"message":'<p>Používáte zastaralý prohlížec <b>{browser_name} {browser_version}</b>. Není zaručeno, že se vám tyto stránky zobrazí korektně a může se stát, že nebudou fungovat vůbec kvůli zastaralému zobrazovacímu jádru vašeho prohlížeče.</p><p>Aktualizujte prosím svůj prohlížeč a nebo si stáhněte nový.</p>',
			"pass":'Risknu to i tak!'
		}
	};

	this.init = function()
	{
		var ready;

		if (ready = this.is_ready()) {
			this.check();
		}

		return ready;
	};


	this.is_ready = function()
	{
		return pwf.mi(['jquery', 'browser']);
	};


	this.check = function()
	{
		var browser = pwf.browser.get_browser();

		if (this.is_known(browser.ident)) {
			if (this.is_deprecated(browser.ident, browser.version)) {
				this.show_deprecation_warning();
			}
		}
	};


	this.is_deprecated = function(browser, version)
	{
		return min_versions[browser] === null || min_versions[browser] > version;
	};


	this.is_known = function(browser)
	{
		return typeof min_versions[browser] !== 'undefined';
	};


	this.show_deprecation_warning = function(lang)
	{
		var lang = typeof lang === 'undefined' ? this.determine_lang():lang;

		if (typeof messages[lang] === 'undefined') {
			return this.show_deprecation_warning('en');
		} else {
			var heading  = messages[lang].heading;
			var message  = messages[lang].message.replace('{browser_name}', browser.get_name()).replace('{browser_version}', browser.get_version());
			var msg_pass = messages[lang].pass;
			var cont     = pwf.jquery('<div class="browser-deprecation"/>');
			var box      = pwf.jquery('<div class="box"/>');
			var overlay  = pwf.jquery('<div class="overlay"/>');
			var msg_box  = pwf.jquery('<div class="message"/>');
			var msg      = pwf.jquery('<div class="inner"><div class="heading">' + heading + '</div><div class="text">' + message + '</div></div>');
			var icon     = pwf.jquery('<span class="icon"/>');
			var pass     = pwf.jquery('<a href="#">' + msg_pass + '</a>');
			var pass_box = pwf.jquery('<div class="pass"/>')
			var bro_box  = pwf.jquery('<div class="browsers"/>');
			var show = pwf.storage.get('pwf_browser_warning');

			cont.append([icon, box]);
			box.append([overlay, msg_box]);
			pass_box.append(pass);
			msg_box.append(msg);
			msg.append([bro_box, pass_box]);

			for (var i = 0; i < browsers.length; i++) {
				var link = pwf.jquery('<a href="' + browsers[i].url + '" class="' + browsers[i].cname + '"><span class="name">' + browsers[i].name + '</span></a>');
				bro_box.append(link);
				link.bind('click', {"browser":browsers[i]}, function(e) {
					e.preventDefault();
					e.stopPropagation();
					window.open(e.data.browser.url);
				});
			}

			pass.bind('click', {"box":box}, callback_hide);
			icon.bind('click', {"box":box}, callback_show);

			pwf.jquery('html').append(cont);

			if (show == 'hide') {
				box.hide();
			}
		}
	};


	var callback_show = function(e)
	{
		e.preventDefault();
		e.stopPropagation();
		e.data.box.stop(true).fadeIn(200);
		pwf.storage.store('pwf_browser_warning', 'show');
	};


	var callback_hide = function(e)
	{
		e.preventDefault();
		e.stopPropagation();
		e.data.box.stop(true).fadeOut(200);
		pwf.storage.store('pwf_browser_warning', 'hide');
	};


	this.determine_lang = function()
	{
		var lang = pwf.jquery('html').attr('lang');

		if (lang.indexOf('-')) lang = lang.split('-')[0];
		if (lang.indexOf('_')) lang = lang.split('_')[0];

		return lang;
	};
});