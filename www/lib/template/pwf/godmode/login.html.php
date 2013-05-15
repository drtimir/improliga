<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?
		$renderer->content_for('styles', 'pwf/elementary');
		$renderer->content_for('styles', 'pwf/form');
		$renderer->content_for("styles", "pwf/god/base");
		$renderer->content_for("styles", "pwf/god/login");

		cfg("dev", "debug") && $renderer->content_for("styles", "devbar");
		$renderer->content_from("head");
		?>
	</head>

	<body class="setup">
		<div class="viewport">
			<?
				$renderer->yield();
				$renderer->slot();
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
