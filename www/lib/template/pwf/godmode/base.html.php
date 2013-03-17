<?

Tag::doctype();
Tag::html();
	Tag::head();

		$script = array();
		$script[] = 'var pwf_user = '.json_encode(array(
			"id" => user()->id,
			"login" => user()->login,
			"name"  => user()->get_name(),
		)).';';

		$script[] = 'var pwf_locale = '.json_encode(System\Locales::get_lang()).';';
		$script[] = 'var pwf_main_menu = '.json_encode(Godmode\Router::get_menu()).';';
		$script[] = 'var pwf_icons = '.json_encode(Godmode\Icon::get_list()).';';
		$script[] = 'var pwf_trans = '.json_encode(System\Locales::get_all_messages()).';';

		content_for("head", '<script type="text/javascript">'.implode('', $script).'</script>');
		content_for("scripts", "pwf/storage");
		content_for("scripts", "pwf/preloader");
		content_for("scripts", "pwf/form/search_tool");
		content_for("scripts", "pwf/form/datetime_picker");
		content_for("scripts", "pwf/form/gps");
		content_for("scripts", "pwf/form/autocompleter");
		content_for("scripts", "pwf/form/location_picker");
		content_for("scripts", "pwf/form/tab_manager");
		content_for("scripts", "pwf/godmode");
		content_for("scripts", "pwf/godmode/preloader");
		content_for("scripts", "pwf/godmode/session");
		content_for("scripts", "pwf/godmode/icon");
		content_for("scripts", "pwf/godmode/window");
		content_for("scripts", "pwf/godmode/window/form");
		content_for("scripts", "pwf/godmode/viewport");
		content_for("scripts", "pwf/godmode/panel_top");
		content_for("scripts", "pwf/godmode/app_drawer");
		content_for("scripts", "pwf/godmode/main_menu");
		content_for("scripts", "pwf/godmode/desktop");
		content_for("scripts", "pwf/godmode/shortcuts");

		content_for('styles', 'pwf/elementary');
		content_for('styles', 'pwf/form');
		content_for("styles", "pwf/form/autocompleter");
		content_for("styles", "pwf/form/search_tool");
		content_for("styles", "pwf/form/tabs");
		content_for("styles", "pwf/god/base");
		content_for("styles", "pwf/god/preloader");
		content_for("styles", "pwf/god/forms");
		content_for("styles", "pwf/god/objects");
		content_for("styles", "pwf/god/layout");
		content_for("styles", "pwf/god/panels");
		content_for("styles", "pwf/god/window");
		content_for("styles", "pwf/god/main_menu");
		content_for("styles", "pwf/god/common");
		content_for("styles", "pwf/god/paginator");

		cfg("dev", "debug") && content_for("styles", "status-dump");
		$menu_icon_size = 24;

		echo content_from("head");

	Tag::close('head');

	Tag::body(array("class" => 'setup'));

		if (logged_in()) {
			Tag::div(array("id" => 'app_drawer', "class" => 'panel app-drawer', "close" => true));
			Tag::div(array("id" => 'panel_top', "class" => 'panel main', "close" => true));
		}

		Tag::div(array(
			"class" => 'viewport_container',
			"content" => Tag::div(array('id' => 'viewport', "output" => false))
		));

	Tag::close('body');
Tag::close('html');
