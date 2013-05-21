<?

if (strpos($_SERVER['HTTP_HOST'], 'intra') !== 0) {
	redirect_now('http://intra.'.str_replace('www.', '', $_SERVER['HTTP_HOST']), 301);
}

echo doctype();
echo html(\System\Locales::get_lang());
	Tag::head();
		$ren->content_for('styles', 'pwf/elementary');
		$ren->content_for('styles', 'pwf/calendar');
		$ren->content_for('styles', 'pwf/browser_control');
		$ren->content_for("styles", "form/search_tool");

		$ren->content_for('styles', 'lib/fancybox');
		$ren->content_for('styles', 'intra/layout');
		$ren->content_for('styles', 'intra/calendar');
		$ren->content_for('styles', 'intra/news');
		$ren->content_for('styles', 'intra/events');
		$ren->content_for('styles', 'intra/discussions');
		$ren->content_for('styles', 'intra/forms');
		$ren->content_for('styles', 'intra/teams');
		$ren->content_for('styles', 'impro/team_comments');
		$ren->content_for('styles', 'intra/profile');
		$ren->content_for('styles', 'intra/rte');

		$ren->content_for('scripts', 'lib/html5');
		$ren->content_for('scripts', 'lib/jquery/fancybox');
		$ren->content_for('scripts', 'pwf/browser_control');
		$ren->content_for('scripts', 'site/global');
		$ren->content_for('scripts', 'site/intranet');

		echo $ren->content_from('head');
	close('head');

	Tag::body();
		echo htmlheader();
			echo div('page-block');
				echo div('logo', $ren->link_for('intra_home', span('hidden', 'Intranet Improligy')));

				echo menu('plain user', array(
					li($ren->icon_for($response->url('intra_profile'), 'impro/objects/profile',  24, array('title' => l('intra_user_profile')))),
					li($ren->icon_for($response->url('intra_profile_settings'), 'impro/objects/settings', 24, array("title" => l('intra_user_settings')))),
					li($ren->icon_for($response->url('intra_logout'), 'godmode/actions/logout', 24, array("title" => l('godmode_user_logout')))),
				));
			close('div');
		close('header');

		echo div('', null, 'container');
			$ren->yield();
			echo span('cleaner', '');
		close('div');

		echo footer();
			echo div('page-block');
				echo span('system', $ren->link('http://pwf.scourge.cz/', introduce()));

				echo span('cleaner', '');
			close('div');
		close('footer');
	close('body');
close('html');
