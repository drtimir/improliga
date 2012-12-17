<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?
		$script = array();
		$script[] = 'var pwf_user = '.json_encode(array(
			"id" => user()->id,
			"login" => user()->login,
			"name"  => user()->get_name(),
		)).';';

		$script[] = 'var pwf_locale = '.json_encode(System\Locales::get_lang()).';';
		$script[] = 'var pwf_main_menu = '.json_encode(Godmode\Page::get_menu_data()).';';
		$script[] = 'var pwf_trans = '.json_encode(System\Locales::get_all_messages()).';';

		content_for("head", '<script type="text/javascript">'.implode('', $script).'</script>');
		content_for("scripts", "pwf/storage");
		content_for("scripts", "pwf/godmode");
		content_for("scripts", "pwf/form/search_tool");
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

		content_for("styles", "god/base");
		content_for("styles", "god/forms");
		content_for("styles", "god/layout");
		content_for("styles", "god/panels");
		content_for("styles", "god/window");
		content_for("styles", "god/main_menu");
		content_for("styles", "god/common");

		cfg("dev", "debug") && content_for("styles", "status-dump");
		$menu_icon_size = 24;
		?>

		<?=content_from("head");?>
	</head>

	<body class="setup">
		<? if (logged_in()) { ?>
			<div id="app_drawer" class="panel app-drawer"></div>
			<div id="panel_top" class="panel main"></div>
		<? } ?>

		<div class="viewport_container"><div id="viewport"></div></div>


		<div id="yacms-logo"></div>
	</body>
</html>
