pwf.rc('ui.public.structure.home', {
	'parents':['ui.structure.section'],

	'storage':{
		'initial':true,
		'locked':false
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
					this.update_menu();
					proto.storage.initial = false;
				} else {
					if (!proto.storage.locked) {
						proto.storage.locked = true;
						pwf.jquery('html,body').stop(true).scrollTo(top, 750, function(proto) {
							return function() {
								proto.storage.locked = false;
							};
						}(proto));
					}
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
				scroll = pwf.jquery(window).scrollTop();

			items.removeClass('active');

			for (var i = 0, len = proto.storage.objects.length; i < len; i++) {
				var
					obj = proto.storage.objects[i],
					el  = obj.get_el(),
					top = el.offset().top;

				if ((scroll - (2*el.height()/3)) < top) {
					var els = pwf.jquery('.menu-' + obj.get('bind')).addClass('active');

					if (!this.is_locked() && document.location.pathname != els.attr('href')) {
						proto.storage.locked = true;
						History.pushState(null, els.html(), els.attr('href'));
						proto.storage.locked = false;
					}

					break;
				}
			}
		},

		'is_locked':function(proto)
		{
			return proto.storage.locked;
		}
	}
});
