<?

echo div('media');

	echo section_heading(l('impro_menu_media'));

	Tag::ul();
		Tag::li(array(
			"content" => link_for('Česká Televize, Divadlo žije: divadelní sporty', 'http://www.ceskatelevize.cz/ivysilani/1095352674-divadlo-zije/21254215088/obsah/227544-tema-divadelni-sporty/')
		));
		Tag::li(array(
			"content" => link_for('Český rozhlas, Just!Impro: Úskalí a radosti improvizace', 'http://www.rozhlas.cz/radiowave/klystyr/_zprava/justimpro-uskali-a-radosti-improvizace--879556')
		));

		Tag::li(array(
			"content" => link_for('Videodokument o Improlize', 'http://www.youtube.com/watch?v=Ik0l_q7gWr8')
		));

		Tag::li(array(
			"content" => link_for('Česká Televize, Divadelní improvizační maraton ostravských Ostružin', 'http://www.ceskatelevize.cz/ivysilani/1183619616-kultura-cz/409233100152001/')
		));

		Tag::li(array(
			"content" => link_for('Česká Televize, Improvizace může trvat i několik hodin a nenudit', 'http://www.ceskatelevize.cz/ct24/kultura/37672-divadelni-improvizace-muze-trvat-i-pet-hodin-a-nenudit/')
		));

		Tag::li(array(
			"content" => link_for('Reflex, Divadlo jako hokej', 'http://www.praliny.cz/Reflex.html')
		));

close('div');
