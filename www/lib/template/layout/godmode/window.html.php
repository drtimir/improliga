<div class="window-content-menu">
	<? slot('menu'); ?>
</div>
<div class="window-content-inner">
	<? yield(); slot(); ?>
</div>
