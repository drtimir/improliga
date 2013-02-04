<menu class="plain main">
<?
	foreach (user()->teams as $team) {
		Tag::li(array("content" => icon_for('godmode/items/team', 16, '/team/'.$team->id.'/', $team->name, array("label" => true))));
	}
?>
</menu>
