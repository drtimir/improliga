pwf.register('responsive', function()
{
	var img_path = '<pixmap(public/bg/block-iter.jpg)>';


	this.is_ready = function()
	{
		return pwf.mi(['jquery', 'locales', 'async']);
	};


	this.init = function()
	{
		this.init_anchors();
	};


	this.init_paralax = function()
	{
		var
			lax = pwf.jquery('.paralax');
			ilax = lax.find('.paralax-inner'),
			boxes = ilax.children('.template'),
			menu = pwf.jquery('.main-menu'),
			mitems = menu.find('a');

		boxes.wrap('<div class="lax-body"/>');
		boxes.wrap('<div class="lax-body-inner"/>');

		for (var i = 0; i < boxes.length; i++) {
			var
				bg = pwf.jquery.div('bg max'),
				img = pwf.jquery('<img/>')
					.bind('load', function(ctrl) {
						return function() { ctrl.reset(); }
					}(this))
					.attr('src', img_path.replace('iter', i))
					.attr('alt', 'background')
					.bind('click', pwf.callbacks.prevent);

			//~ bg.append(img).insertBefore(boxes[i].parentNode);
			bg.insertBefore(boxes[i].parentNode);
		}

		for (var i = 0; i < mitems.length; i++) {
			var
				item = pwf.jquery(mitems[i]),
				href = item.attr('href').replace(/^\//, '');

			//~ item.attr('href', '#!' + href);

			if (typeof boxes[i] != 'undefined') {
				var
					box = pwf.jquery(boxes[i]),
					p = box.parents('.lax-body').first();

				p.attr('id', href);
			}
		}

		return this;
	};


	this.init_anchors = function()
	{
		var links = pwf.jquery('#main-menu a');

		for (var i = 0; i < links.length; i++) {
			var link = pwf.jquery(links[i]);
			link.attr('href', '/#!' + link.attr('href').replace(/^\//, ''));
		}

		return this;
	};
});
