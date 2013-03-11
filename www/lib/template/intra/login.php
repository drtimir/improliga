<?

Tag::doctype();
Tag::html();
	Tag::head();

		content_for("styles", "form/search_tool");
		content_for('styles', 'intra/layout');
		content_for('styles', 'intra/calendar');
		content_for('styles', 'intra/news');
		content_for('styles', 'intra/events');
		content_for('styles', 'intra/forms');
		content_for('styles', 'intra/login');

		echo content_from('head');
	Tag::close('head');

	Tag::body(array("class" => 'page_login'));
		Tag::div(array("id" => 'container'));
			Tag::div(array("class" => 'page-block'));

				Tag::div(array("class" => array('block', 'left')));
					echo link_for(section_heading(l('intra_name')), '/');
					Tag::p(array("content" => l('intra_desc')));

				Tag::close('div');

				Tag::div(array("class" => array('block', 'right')));
					slot();
				Tag::close('div');

				Tag::span(array("class" => 'cleaner', "close" => true));
				yield();
			Tag::close('div');
			Tag::span(array("class" => 'cleaner', "close" => true));
		Tag::close('div');
	Tag::close('body');
Tag::close('html');
