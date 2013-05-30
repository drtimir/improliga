<?

echo Tag::doctype();
Tag::html();
	Tag::head();

		$script = array();
		$script[] = 'var pwf_user = '.json_encode(array(
			"id"    => $request->user()->id,
			"login" => $request->user()->login,
			"name"  => $request->user()->get_name(),
		)).';';

		$script[] = 'var pwf_locale = '.json_encode($ren->locales()->get_locale()).';';
		$script[] = 'var pwf_main_menu = '.json_encode(Godmode\Router::get_menu($request, $ren)).';';
		$script[] = 'var pwf_icons = '.json_encode(Godmode\Icon::get_list()).';';
		$script[] = 'var pwf_trans = '.json_encode($locales->get_messages()).';';

		$renderer->content_for("head", '<script type="text/javascript">'.implode('', $script).'</script>');
		$renderer->content_for('scripts', 'lib/jquery');
		$renderer->content_for('scripts', 'lib/functions');
		$renderer->content_for('scripts', 'pwf');
		$renderer->content_for("scripts", "pwf/storage");
		$renderer->content_for("scripts", "pwf/preloader");
		$renderer->content_for("scripts", "pwf/form/search_tool");
		$renderer->content_for("scripts", "pwf/form/date_picker");
		$renderer->content_for("scripts", "pwf/form/time_picker");
		$renderer->content_for("scripts", "pwf/form/gps");
		$renderer->content_for("scripts", "pwf/form/autocompleter");
		$renderer->content_for("scripts", "pwf/form/location_picker");
		$renderer->content_for("scripts", "pwf/form/tab_manager");
		$renderer->content_for("scripts", "pwf/lib/rte");
		$renderer->content_for("scripts", "pwf/godmode");
		$renderer->content_for("scripts", "pwf/godmode/preloader");
		$renderer->content_for("scripts", "pwf/godmode/session");
		$renderer->content_for("scripts", "pwf/godmode/icon");
		$renderer->content_for("scripts", "pwf/godmode/window");
		$renderer->content_for("scripts", "pwf/godmode/window/form");
		$renderer->content_for("scripts", "pwf/godmode/viewport");
		$renderer->content_for("scripts", "pwf/godmode/panel_top");
		$renderer->content_for("scripts", "pwf/godmode/app_drawer");
		$renderer->content_for("scripts", "pwf/godmode/main_menu");
		$renderer->content_for("scripts", "pwf/godmode/desktop");
		$renderer->content_for("scripts", "pwf/godmode/shortcuts");

		$renderer->content_for('styles', 'pwf/elementary');
		$renderer->content_for('styles', 'pwf/form');
		$renderer->content_for("styles", "pwf/form/autocompleter");
		$renderer->content_for("styles", "pwf/form/search_tool");
		$renderer->content_for("styles", "pwf/form/tabs");
		$renderer->content_for("styles", "pwf/form/rte");
		$renderer->content_for("styles", "pwf/form/datepicker");
		$renderer->content_for("styles", "pwf/god/common");
		$renderer->content_for("styles", "pwf/god/base");
		$renderer->content_for("styles", "pwf/god/preloader");
		$renderer->content_for("styles", "pwf/god/forms");
		$renderer->content_for("styles", "pwf/god/objects");
		$renderer->content_for("styles", "pwf/god/layout");
		$renderer->content_for("styles", "pwf/god/panels");
		$renderer->content_for("styles", "pwf/god/window");
		$renderer->content_for("styles", "pwf/god/main_menu");
		$renderer->content_for("styles", "pwf/god/paginator");

		$menu_icon_size = 24;

		echo $renderer->content_from("head");

	Tag::close('head');

	Tag::body(array("class" => 'setup'));

		if ($request->logged_in()) {
			Tag::div(array("id" => 'app_drawer', "class" => 'panel app-drawer', "close" => true));
			Tag::div(array("id" => 'panel_top', "class" => 'panel main', "close" => true));
		}

		Tag::div(array(
			"class" => 'viewport_container',
			"content" => Tag::div(array('id' => 'viewport', "output" => false))
		));

	Tag::close('body');
Tag::close('html');
