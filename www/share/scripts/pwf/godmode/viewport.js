pwf.register('viewport', function()
{
	var
		element = null;

	this.is_ready = function()
	{
		return $.isReady && (element = $('#viewport')).length === 1;
	};


	this.add_window = function(win)
	{
		var pos = win.attr('position');
		element.append(win.get_container());
		win.reposition(pos.x, pos.y).update_pos();
	};


	this.get_el = function()
	{
		return element;
	};


	this.get_offset = function()
	{
		return element.offset();
	};


	this.resize = function()
	{
		var xScroll, yScroll, offset = this.get_offset();

		if (window.innerHeight) {
			xScroll = window.innerWidth + window.scrollMaxX;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			xScroll = document.body.offsetWidth;
		}

		if (window.innerHeight) {
			yScroll = window.innerHeight;
		} else { // Explorer Mac...would also work in Explorer 6 Strict, Mozilla and Safari
			yScroll = document.body.offsetHeight;
		}

		var
			windowWidth = $(window).width(),
			windowHeight = $(window).height();

		pageHeight = yScroll < windowHeight ? windowHeight:yScroll - offset.top;
		pageWidth = (xScroll < windowWidth ? xScroll:windowWidth) - offset.left;

		var css = {
			"width":pageWidth + 'px',
			"height":pageHeight + 'px',
		};

		element.css(css);
	};


	this.get_size = function()
	{
		return {"x":element.height(), "y":element.width()};
	};

	this.get_max_size = function()
	{
		var voffset = pwf.panel_top.get_el().height()+29;
		var hoffset = pwf.app_drawer.get_el().width()+39;
		var wscreen = $(window).width();
		var hscreen = $(window).height();
		return {"x":wscreen - hoffset, "y":hscreen - voffset};
	};
});
