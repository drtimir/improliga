<?

if (strpos($_SERVER['HTTP_HOST'], 'intra') !== 0) {
	redirect_now('http://intra.'.str_replace('www.', '', $_SERVER['HTTP_HOST']), 301);
}

Tag::doctype();
Tag::html(array("lang" => \System\Locales::get_lang()));
	Tag::head();
		content_for('styles', 'pwf/elementary');
		content_for('styles', 'pwf/calendar');
		content_for('styles', 'pwf/browser_control');

		content_for("styles", "form/search_tool");

		content_for('styles', 'lib/fancybox');
		content_for('styles', 'intra/layout');
		content_for('styles', 'intra/calendar');
		content_for('styles', 'intra/news');
		content_for('styles', 'intra/events');
		content_for('styles', 'intra/discussions');
		content_for('styles', 'intra/forms');
		content_for('styles', 'intra/teams');
		content_for('styles', 'impro/team_comments');
		content_for('styles', 'intra/profile');
		content_for('styles', 'intra/rte');

		content_for('scripts', 'lib/jquery/fancybox');
		content_for('scripts', 'pwf/browser_control');
		content_for('scripts', 'site/intranet');

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
