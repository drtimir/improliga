<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?
			content_for('styles', 'intra/layout');
			content_for('styles', 'intra/calendar');
		?>
		<?= content_from('head');?>
	</head>

	<body>
		<header>
			<div class="page-block">
				<div class="logo"><a href="/"><span class="hidden">Intranet Improligy</span></a></div>
				<menu class="plain user">
					<li><?=icon_for('impro/objects/profile',  24, '/profile/', l('intra_user_profile'))?></li>
					<li><?=icon_for('impro/objects/settings', 24, '/settings/', l('intra_user_settings'))?></li>
					<li><?=icon_for('godmode/actions/logout', 24, '/logout/', l('godmode_user_logout'))?></li>
				</menu>
			</div>
		</header>
		<div id="container">
			<? yield(); ?>
			<span class="cleaner"></span>
		</div>
		<footer>
			<div class="page-block">
				<?=System\Output::introduce()?>
			</div>
		</footer>
	</body>
</html>
<?
