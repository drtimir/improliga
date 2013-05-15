$(function() { $('a.fancybox, .fancybox a, .input-image a').fancybox(); });


var bind_ext_links = function()
{
	var els = $('a.ext, a.location_map');

	for  (var i = 0; i < els.length; i++) {
		var el = $(els[i]);

		el.unbind('click').bind('click', function(e) {
			e.preventDefault();
			e.stopPropagation();

			window.open($(this).attr('href'));
		});
	}
};


$(function() { bind_ext_links(); });
