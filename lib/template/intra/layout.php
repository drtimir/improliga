<?

echo doctype();
echo html($locales->get_lang());
	echo head();

		$ren->content_for('styles', 'styles/pwf/elementary');
		$ren->content_for('styles', 'styles/lib/calendar');
		$ren->content_for('styles', 'styles/pwf/browser_control');
		$ren->content_for('styles', 'styles/pwf/form');
		$ren->content_for('styles', 'styles/pwf/form/datetimepicker');
		$ren->content_for('styles', 'styles/pwf/form/datepicker');
		$ren->content_for('styles', 'styles/pwf/form/timepicker');
		$ren->content_for('styles', 'styles/pwf/form/picker_image');
		$ren->content_for('styles', 'styles/pwf/form/autocompleter');
		$ren->content_for('styles', 'styles/pwf/form/rte');
		$ren->content_for('styles', 'styles/pwf/form/tabs');

		$ren->content_for('styles', 'styles/lib/fancybox');
		$ren->content_for('styles', 'styles/intra/layout');
		$ren->content_for('styles', 'styles/intra/common');
		$ren->content_for('styles', 'styles/intra/header');
		$ren->content_for('styles', 'styles/intra/menu_left');
		$ren->content_for('styles', 'styles/intra/calendar');
		$ren->content_for('styles', 'styles/intra/news');
		$ren->content_for('styles', 'styles/intra/events');
		$ren->content_for('styles', 'styles/intra/discussions');
		$ren->content_for('styles', 'styles/intra/forms');
		$ren->content_for('styles', 'styles/intra/teams');
		$ren->content_for('styles', 'styles/impro/team_comments');
		$ren->content_for('styles', 'styles/intra/profile');
		$ren->content_for('styles', 'styles/intra/rte');
		$ren->content_for('styles', 'styles/intra/requests');
		$ren->content_for('styles', 'styles/intra/reporter');

		$ren->content_for('scripts', "site/lib/intranet");

		echo $ren->content_from('head');
	close('head');

	Tag::body();
		echo htmlheader('offset-y');
			echo div('page-block');
				echo div('logo', $ren->link_for('home', span('hidden', 'Intranet')));
				echo div('reporter', '');

				echo menu('plain user', array(
					li($ren->link_for('profile', array($request->user()->avatar->to_html($ren, 24,24), span('label', \Impro\User::get_name($request->user()))), array('title' => $locales->trans('intra_user_profile')))),
					li($ren->icon_for($response->url('profile_settings'), 'impro/objects/settings', 24, array("title" => $locales->trans('intra_user_settings')))),
					li($ren->icon_for($response->url('logout'), 'godmode/actions/logout', 24, array("title" => $locales->trans('godmode_user_logout')))),
				));
			close('div');
		close('header');

		echo div('', null, 'container');
			echo div('page-block');
				require BASE_DIR.'/lib/template/intra/menu.php';

				echo div('block_right');
					$ren->yield();
					echo span('cleaner', '');
				close('div');
				echo span('cleaner', '');
			close('div');
		close('div');

		echo footer();
			echo div('page-block');
				echo span('system', $ren->link_ext('http://pwf.scourge.cz/', \System\Status::introduce()));

				echo ul('plain footer-menu', array(
					li($ren->link('http://www.improliga.cz/', $locales->trans('intra_public'))),
					li($ren->link_for('terms', $locales->trans('intra_terms'))),
					li($ren->link_for('support', $locales->trans('intra_support'))),
				));

				echo span('cleaner', '');
			close('div');
		close('footer');
		?><script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-40099806-1']);_gaq.push(['_setDomainName', 'improliga.cz']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script><?
	close('body');
close('html');
