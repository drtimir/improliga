<?

if (strpos($_SERVER['HTTP_HOST'], 'intra') !== 0) {
	redirect_now('http://intra.'.str_replace('www.', '', $_SERVER['HTTP_HOST']), 301);
}

echo doctype();
echo html($locales->get_lang());
	Tag::head();
		$ren->content_for('styles', 'pwf/elementary');
		$ren->content_for('styles', 'pwf/calendar');
		$ren->content_for('styles', 'pwf/browser_control');
		$ren->content_for("styles", "pwf/form");
		$ren->content_for("styles", "pwf/form/datetimepicker");
		$ren->content_for("styles", "pwf/form/datepicker");
		$ren->content_for("styles", "pwf/form/timepicker");
		$ren->content_for("styles", "pwf/form/picker_image");
		$ren->content_for("styles", "pwf/form/autocompleter");
		$ren->content_for("styles", "pwf/form/rte");
		$ren->content_for("styles", "pwf/form/tabs");
		$ren->content_for("styles", "form/search_tool");
		$ren->content_for("styles", "calendar");

		$ren->content_for('styles', 'lib/fancybox');
		$ren->content_for('styles', 'intra/layout');
		$ren->content_for('styles', 'intra/common');
		$ren->content_for('styles', 'intra/header');
		$ren->content_for('styles', 'intra/menu_left');
		$ren->content_for('styles', 'intra/calendar');
		$ren->content_for('styles', 'intra/news');
		$ren->content_for('styles', 'intra/events');
		$ren->content_for('styles', 'intra/discussions');
		$ren->content_for('styles', 'intra/forms');
		$ren->content_for('styles', 'intra/teams');
		$ren->content_for('styles', 'impro/team_comments');
		$ren->content_for('styles', 'intra/profile');
		$ren->content_for('styles', 'intra/rte');
		$ren->content_for('styles', 'intra/requests');
		$ren->content_for('styles', "intra/reporter");

		$ren->content_for('scripts', 'lib/browser');
		$ren->content_for('scripts', 'lib/html5');
		$ren->content_for('scripts', 'lib/jquery/fancybox');
		$ren->content_for('scripts', 'pwf/browser_control');
		$ren->content_for('scripts', 'pwf/locales');
		$ren->content_for('scripts', 'pwf/icon');
		$ren->content_for('scripts', 'pwf/form/tab_manager');
		$ren->content_for('scripts', 'pwf/lib/rte');
		$ren->content_for('scripts', 'pwf/form/date_picker');
		$ren->content_for('scripts', 'pwf/form/time_picker');
		$ren->content_for('scripts', 'pwf/form/autocompleter');
		$ren->content_for('scripts', 'pwf/form/location_picker');
		$ren->content_for('scripts', 'pwf/form/jquery.gmap');
		$ren->content_for('scripts', 'pwf/form/gps');
		$ren->content_for('scripts', "pwf/godmode/relman");
		$ren->content_for('scripts', "site/reporter");
		$ren->content_for('scripts', 'site/global');
		$ren->content_for('scripts', 'site/intranet');

		echo $ren->content_from('head');
	close('head');

	Tag::body();
		echo htmlheader();
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
				require ROOT.'/lib/template/intra/menu.php';

				echo div('block_right');
					$ren->yield();
					echo span('cleaner', '');
				close('div');
				echo span('cleaner', '');
			close('div');
		close('div');

		echo footer();
			echo div('page-block');
				echo span('system', $ren->link_ext('http://pwf.scourge.cz/', introduce()));

				echo ul('plain footer-menu', array(
					li($ren->link('http://www.improliga.cz/', $locales->trans('intra_public'))),
					li($ren->link_for('terms', $locales->trans('intra_terms'))),
				));

				echo span('cleaner', '');
			close('div');
		close('footer');
		?><script type="text/javascript">var _gaq = _gaq || [];_gaq.push(['_setAccount', 'UA-40099806-1']);_gaq.push(['_setDomainName', 'improliga.cz']);_gaq.push(['_trackPageview']);(function() {var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);})();</script><?
	close('body');
close('html');
