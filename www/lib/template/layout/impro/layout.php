<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?
			content_for('styles', 'impro/layout/base');
			content_for('styles', 'impro/layout/footer');
		?>
		<?= content_from('head');?>
	</head>

	<body>
		<header>
			<div class="container">
				<a href="" class="logo"><strong class="hidden">Improliga</strong></a>
			</div>
		</header>

		<div id="content">
			<div class="container">
				<? yield(); ?>
				<? slot(); ?>
			</div>
		</div>

		<footer>
			<div class="container">
				<div class="dynamic">
					<div class="contact">
						<h3>Kontakt</h3>
						<address>
							Improliga<br>
							Česká improvizační liga, o.s.<br>
							Přemyšlenská 1102<br>
							182 00 Praha 8
						</address>

						<a href="/kontakty/">Více kontaktů</a>
					</div>

					<div class="partners">
						<h3>Partneři</h3>
					</div>
					<span class="cleaner"></span>
				</div>

				<div class="system">
					Created by just-paja, <?=System\Output::introduce()?>
				</div>
			</div>
		</footer>
	</body>
</html>
<?
