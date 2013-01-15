<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?
			content_for('styles', 'intra/layout');
		?>
		<?= content_from('head');?>
	</head>

	<body>
		<header>
			<div class="page-block">
				<div class="logo"><a href="/"><span class="hidden">Intranet Improligy</span></a></div>
				<menu class="plain main">
					<li><a href="/">Zeď</a></li>

					<?

					foreach (user()->teams as $team) {
						?>
						<li><a href="/team/<?=$team->id?>/"><?=$team->name?></a></li>
						<?
					}

					?>
				</menu>
				<menu class="plain user">
					<li><?=icon_for('impro/objects/profile',  24, '/profile/', l('intra_user_profile'))?></li>
					<li><?=icon_for('impro/objects/settings', 24, '/settings/', l('intra_user_settings'))?></li>
					<li><?=icon_for('godmode/actions/logout', 24, '/logout/', l('godmode_user_logout'))?></li>
				</menu>
			</div>
		</header>
		<div id="container">
			<? yield(); ?>
		</div>
		<footer>
			<div class="page-block">
				<?=System\Output::introduce()?>
			</div>
		</footer>
	</body>
</html>
<?
