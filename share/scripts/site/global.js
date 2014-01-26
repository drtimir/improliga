
var bind_ext_links = function()
{
	var els = pwf.jquery('a.ext, a.location_map');

	for  (var i = 0; i < els.length; i++) {
		var el = pwf.jquery(els[i]);

		el.unbind('click').bind('click', function(e) {
			e.preventDefault();
			e.stopPropagation();

			window.open(pwf.jquery(this).attr('href'));
		});
	}
};


pwf.wi(['jquery'], function() {
	pwf.jquery('a.fancybox, .fancybox a, .input-image a, a.lightbox').fancybox();
	bind_ext_links();
});
