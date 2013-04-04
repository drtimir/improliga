<?

Tag::doctype();
Tag::html();
	Tag::head();
		content_for('scripts', 'lib/html5');
		content_for('styles', 'pwf/calendar');
		content_for('styles', 'impro/layout/base');
		content_for('styles', 'impro/layout/footer');
		content_for('styles', 'impro/layout/homepage');
		content_for('styles', 'impro/events');
		content_for('styles', 'impro/teams');
		content_for('styles', 'impro/about');
		echo content_from('head');

		?>
		<link rel="icon" type="image/ico" href="/favicon.ico">
		<link rel="icon" type="image/png" href="/favicon.png">
		<?
	Tag::close('head');

	Tag::body();

		Tag::header();
			echo div('inner');
				echo div('container');
					echo div('logo', link_for(Stag::strong(array("class" => 'hidden text', "content" => l('impro_name'))), '/'));
					echo div('logo-label', link_for(Stag::strong(array("class" => 'hidden text', "content" => l('impro_name'))), '/'));

					Tag::menu(array("class" => 'plain main left'));
						Tag::li(array("content" => link_for(l('impro_menu_home'), '/')));
						Tag::li(array("content" => link_for(l('impro_menu_teams'), '/tymy/')));
						Tag::li(array("content" => link_for(l('impro_menu_events'), '/udalosti/')));
					Tag::close('menu');

					Tag::menu(array("class" => 'plain main right'));
						Tag::li(array("content" => link_for(l('impro_menu_about'), '/o-improlize/')));
						Tag::li(array("content" => link_for(l('impro_contact'), '/kontakty/')));
					Tag::close('menu');

				Tag::close('div');
				echo div('header-bottom');
			Tag::close('div');

		Tag::close('header');

		Tag::div(array("class" => 'top'));
			Tag::div(array("class" => 'bg', "content" => Tag::img(array(
				"src" => '/share/pixmaps/layout/background.jpg',
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
					echo div('social', array(
						icon_for('impro/social/facebook', 32, 'http://www.facebook.com/improligacz', 'Improliga na facebooku')
					));
					echo div(array("class" => 'partners'));
						echo section_heading(l('impro_partners'), 3);

						\System\Template::partial('impro/static/partners', array("partners" => \Impro\Partner::visible()->fetch()));
					close('div');
					Tag::span(array("class" => 'cleaner', "close" => true));
				close('div');


				echo div('system');
					echo div('left');
						Tag::menu(array("class" => 'plain main'));
							Tag::li(array("content" => link_for(l('impro_menu_home'), '/')));
							Tag::li(array("content" => link_for(l('impro_menu_intranet'), '/intranet/')));
							Tag::li(array("content" => link_for(l('impro_menu_teams'), '/tymy/')));
							Tag::li(array("content" => link_for(l('impro_menu_events'), '/udalosti/')));
							Tag::li(array("content" => link_for(l('impro_menu_about'), '/o-improlize/')));
							Tag::li(array("content" => link_for(l('impro_contact'), '/kontakty/')));
						close('menu');
					close('div');

					echo div('right');
						echo div('credits', t('impro_credits', System\Output::introduce()));
					close('div');
					Tag::span(array("class" => 'cleaner', "close" => true));
				close('div');
			close('div');
		close('footer');
	close('body');
close('html');
