<?

if (strpos($_SERVER['HTTP_HOST'], 'intra') !== 0) {
	redirect_now('http://intra.'.str_replace('www.', '', $_SERVER['HTTP_HOST']), 301);
}

echo doctype();
echo html($locales->get_lang());
	Tag::head();

		$ren->content_for('styles', 'styles/pwf/elementary');
		$ren->content_for('styles', 'styles/pwf/form');
		$ren->content_for('styles', 'styles/intra/common');
		$ren->content_for('styles', 'styles/intra/layout');
		$ren->content_for('styles', 'styles/intra/calendar');
		$ren->content_for('styles', 'styles/intra/news');
		$ren->content_for('styles', 'styles/intra/events');
		$ren->content_for('styles', 'styles/intra/forms');
		$ren->content_for('styles', 'styles/intra/login');

		$ren->content_for('scripts', "scripts/intra/login");
		echo $ren->content_from('head');
	close('head');

	Tag::body(array("class" => 'page_login'));
		echo htmlheader();
			echo div('logo', '');
		close('header');

		echo div('', null, 'container');
			echo div('page-block');

				echo div(array('block', 'left'));
					echo div('context', array(
						$ren->link_for('home', $ren->heading_layout($locales->trans('intra_name'))),
						Stag::p(array("content" => $locales->trans('intra_desc'))),
					));

					echo div('context', array(
						$ren->heading($locales->trans('intra_register')),
						Stag::p(array("content" => $locales->trans('intra_register_desc', 'http://www.improliga.cz/kontakty/'))),
					));

				close('div');

				echo div(array('block', 'right'));
					$ren->slot();
				close('div');

				echo span('cleaner', '');
				$ren->yield();
			close('div');
			echo span('cleaner', '');
		close('div');
		?><script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-40099806-1']);_gaq.push(['_setDomainName', 'improliga.cz']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script><?
	close('body');
close('html');
