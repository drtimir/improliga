pwf.rc('ui.structure.home', {
	'parents':['ui.structure.section'],

	'storage':{
		'initial':true
	},

	'proto':{
		'map':['', 'o-improlize', 'predstaveni', 'tymy', 'workshopy', 'media-o-improlize', 'kontakty'],


		'loaded':function(proto)
		{
			var
				section  = this.get('section'),
				children = this.get_el('inner').children(),
				index, child, top;

			if (section === null) {
				section = '';
			}

			index = proto('map').indexOf(section);

			if (index >= 0) {
				child = pwf.jquery(children[index]);
				top = child.offset().top;

				if (proto.storage.initial) {
					pwf.jquery('html,body').stop(true).scrollTo(top, 0);
					proto.storage.initial = false;
				} else {
					pwf.jquery('html,body').stop(true).scrollTo(top, 750);
				}
			}
		}
	},


	'public':{
		'update_menu':function(proto)
		{
			var
				items  = pwf.jquery('#main-menu').first().find('a'),
				active = null,
				scroll = pwf.jquery('html, body').scrollTop();

			items.removeClass('active');

			for (var i = 0, len = proto.storage.objects.length; i < len; i++) {
				var
					obj = proto.storage.objects[i],
					el  = obj.get_el(),
					top = el.offset().top;
v(scroll - (el.height()/2), top);
				if (scroll - (2*el.height()/3) < top) {
					pwf.jquery('.menu-' + obj.get('bind')).addClass('active');
					break;
				}
			}
		}
	}
});
