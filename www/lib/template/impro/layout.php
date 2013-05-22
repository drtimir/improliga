<?

echo doctype();
Tag::html(array("lang" => \System\Locales::get_lang()));
	Tag::head();

		$renderer->content_for('scripts', 'lib/browser');
		$renderer->content_for('scripts', 'lib/html5');
		$renderer->content_for('scripts', 'pwf/browser_control');
		$renderer->content_for('scripts', 'lib/jquery/fancybox');
		$renderer->content_for('scripts', 'site/global');
		$renderer->content_for('scripts', 'site/public');

		$renderer->content_for('styles', 'lib/fancybox');
		$renderer->content_for('styles', 'pwf/calendar');
		$renderer->content_for('styles', 'impro/layout/base');
		$renderer->content_for('styles', 'impro/layout/footer');
		$renderer->content_for('styles', 'impro/layout/homepage');
		$renderer->content_for('styles', 'impro/events');
		$renderer->content_for('styles', 'impro/teams');
		$renderer->content_for('styles', 'impro/about');
		$renderer->content_for('styles', 'pwf/browser_control');

		echo $renderer->content_from('head');

		?>
		<link rel="icon" type="image/ico" href="/favicon.ico">
		<link rel="icon" type="image/png" href="/favicon.png">
		<?
	Tag::close('head');

	Tag::body();

		Tag::header();
			echo div('inner');
				echo div('container');
					echo div('logo', $ren->link_for('home', Stag::strong(array("class" => 'hidden text', "content" => l('impro_name')))));
					echo div('logo-label', $ren->link_for('home', Stag::strong(array("class" => 'hidden text', "content" => l('impro_name')))));

					echo menu('plain main left', array(
						li($ren->link_for('home', l('impro_menu_home'))),
						li($ren->link_for('teams', l('impro_menu_teams'))),
						li($ren->link_for('events', l('impro_menu_events'))),
					));

					echo menu('plain main right', array(
						li($ren->link_for('about', l('impro_menu_about'))),
						li($ren->link_for('contacts', l('impro_contact'))),
					));

				close('div');
				echo div('header-bottom', '');
			close('div');

		Tag::close('header');

		Tag::div(array("class" => 'top'));
			Tag::div(array("class" => 'bg', "content" => Tag::img(array(
				"src" => '/share/pixmaps/layout/background.jpg',
				"alt" => 'background',
				"output" => false,
			))));

			Tag::div(array("id" => 'content'));
				Tag::div(array("class" => 'container'));
					$renderer->yield();
					$renderer->slot();
				Tag::close('div');
			Tag::close('div');
		Tag::close('div');

		Tag::footer();
			Tag::div(array("class" => 'container'));
				Tag::div(array("class" => 'dynamic'));
					echo div('social', $ren->icon_for('http://www.facebook.com/improligacz', 'impro/social/facebook', 32, array("title" => 'Improliga na facebooku')));
					echo div(array("class" => 'partners'));
						echo $renderer->heading(l('impro_partners'));
						$renderer->render_partial('impro/static/partners', array("partners" => \Impro\Partner::visible()->fetch()));
					close('div');
					echo span('cleaner', '');
				close('div');

				echo div('system');
					echo div('left', STag::menu(array(
						"class" => 'plain main',
						"content" => array(
							li($ren->link_for('home', l('impro_menu_home'))),
							li($ren->link_for('intranet_redir', l('impro_menu_intranet'))),
							li($ren->link_for('teams', l('impro_menu_teams'))),
							li($ren->link_for('events', l('impro_menu_events'))),
							li($ren->link_for('about', l('impro_menu_about'))),
							li($ren->link_for('contacts', l('impro_contact'))),
						)
					)));

					echo div('right', div('credits', t('impro_credits', introduce())));
					echo span('cleaner', '');
				close('div');
			close('div');
		close('footer');
		?><script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-40099806-1']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script><?
	close('body');
close('html');
