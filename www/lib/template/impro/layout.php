<?

Tag::doctype();
Tag::html();
	Tag::head();
		content_for('styles', 'pwf/calendar');
		content_for('styles', 'impro/layout/base');
		content_for('styles', 'impro/layout/footer');
		content_for('styles', 'impro/events');
		content_for('styles', 'impro/teams');
		echo content_from('head');
	Tag::close('head');

	Tag::body();

		Tag::header();
			Tag::div(array("class" => 'container'));
				Tag::div(array("class" => 'logo', "content" =>
					link_for(Tag::strong(array("class" => 'hidden text', "output" => false, "content" => 'Improliga')), '/')
				));

				Tag::menu(array("class" => 'plain main'));
					Tag::li(array("content" => link_for(l('impro_menu_home'), '/')));
					Tag::li(array("content" => link_for(l('impro_menu_about'), '/o-improlize/')));
					Tag::li(array("content" => link_for(l('impro_menu_teams'), '/tymy/')));
					Tag::li(array("content" => link_for(l('impro_menu_events'), '/udalosti/')));
				Tag::close('menu');
			Tag::close('div');
		Tag::close('header');

		Tag::div(array("class" => 'top'));
			Tag::div(array("class" => 'bg', "content" => Tag::img(array(
				"src" => '/share/pixmaps/impro/bg.jpg',
				"alt" => 'background',
				"output" => false,
			))));

			Tag::div(array("id" => 'content'));
				Tag::div(array("class" => 'container'));
					yield();
					slot();
				Tag::close('div');
			Tag::close('div');
		Tag::close('div');

		Tag::footer();
			Tag::div(array("class" => 'container'));
				Tag::div(array("class" => 'dynamic'));
					Tag::div(array("class" => 'contact'));
						echo section_heading(l('impro_contact'), 3);
						Tag::address(array("content" => l('impro_address')));
						echo link_for(l('impro_more_contacts'), '/kontakty/');
					Tag::close('div');

					Tag::div(array("class" => 'partners'));
						echo section_heading(l('impro_partners'), 3);
					Tag::close('div');
					Tag::span(array("class" => 'cleaner', "close" => true));
				Tag::close('div');

				Tag::div(array("class" => 'system', "content" => t('impro_credits', System\Output::introduce())));
			Tag::close('div');
		Tag::close('footer');
	Tag::close('body');
Tag::close('html');
