<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?
		content_for("styles", "god/base");
		content_for("styles", "god/login");
		cfg("dev", "debug") && content_for("styles", "status-dump");
		content_from("head");
		?>
	</head>

	<body class="setup">
		<div class="viewport">
			<?
				System\Output::yield();
				System\Output::slot();
			?>

			<div class="browsers">
				<span class="firefox" title="<?=l("godmode_browser_supported")?>"></span>
				<span class="chrome" title="<?=l("godmode_browser_supported")?>"></span>
				<span class="opera" title="<?=l("godmode_browser_supported")?>"></span>
				<span class="safari" title="<?=l("godmode_browser_not_supported")?>"></span>
				<span class="ie" title="<?=l("godmode_browser_not_supported")?>"></span>
			</div>

		</div>
		<div id="yacms-logo"></div>
	</body>
</html>
