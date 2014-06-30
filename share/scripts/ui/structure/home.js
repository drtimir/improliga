pwf.rc('ui.structure.home', {
	'parents':['ui.structure.section'],

	'proto':{
		'map':['', 'o-improlize', 'predstaveni', 'tymy', 'workshopy', 'media-o-improlize', 'kontakty'],


		'loaded':function(proto)
		{
			var
				children = this.get_el('inner').children(),
				index = proto('map').indexOf(this.get('section')),
				child;

			if (index >= 0) {
				child = pwf.jquery(children[index]);
				pwf.jquery('html,body').stop(true).scrollTo(child.offset().top, 750);
			}
		}
	}
});
