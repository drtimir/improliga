<?

Tag::doctype();
Tag::html();
	Tag::head();
		content_for('styles', 'intra/layout');
		content_for('styles', 'intra/calendar');
		content_for('styles', 'intra/news');
		content_for('styles', 'intra/events');
		content_for('styles', 'intra/discussions');

		echo content_from('head');
	Tag::close('head');

	Tag::body();
		Tag::header();
			Tag::div(array("class" => 'page-block'));
				Tag::div(array(
					"class" => 'logo',
					"content" => link_for(Tag::span(array("output" => false, "class" => 'hidden', "content" => 'Intranet Improligy')), '/'),
				));

				Tag::menu(array("class" => 'plain user'));
					Tag::li(array("content" => icon_for('impro/objects/profile',  24, '/profile/', l('intra_user_profile'))));
					Tag::li(array("content" => icon_for('impro/objects/settings', 24, '/settings/', l('intra_user_settings'))));
					Tag::li(array("content" => icon_for('godmode/actions/logout', 24, '/logout/', l('godmode_user_logout'))));
				Tag::close('menu');
			Tag::close('div');
		Tag::close('header');

		Tag::div(array("id" => 'container'));
			yield();
			Tag::span(array("class" => 'cleaner', "close" => true));
		Tag::close('div');

		Tag::footer();
			Tag::div(array("class" => 'page-block'));
				Tag::span(array(
					"class"   => 'system',
					"content" => link_for(System\Output::introduce(), 'http://pwf.scourge.cz/'),
				));

				Tag::span(array("class" => 'cleaner', "close" => true));
			Tag::close('div');
		Tag::close('footer');
	Tag::close('body');
Tag::close('html');
