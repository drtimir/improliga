<?

echo div('page-block');

	echo div(array('block', 'left', 'layout_34'));
		echo $ren->heading_layout('Stránka nenalezena');
		Tag::p(array("content" => 'Stránka, kterou jste hledali neexistuje. Pravděpodobně vám někdo poslal starý nebo špatný odkaz.'));
		Tag::p(array("content" => 'Ale to přece nevadí, my máme stránek hrozně moc.'));
		echo ul('plain', array(
			li($ren->link_for('events', 'Události').' - Přijďte se podívat na některé z představeí našich týmů'),
			li($ren->link_for('teams', 'Týmy').' - Projďete si seznam našich týmů'),
			li($ren->link_for('about', 'O Improlize').' - Přečtěte si něco o České Improlize'),
			li($ren->link_for('contacts', 'Kontakty').' - Napište nám'),
		));
	close('div');

	echo div(array('block', 'right', 'layout_14'));
		$foul = \Impro\Foul::get_random();

		echo $ren->heading($foul->name);
		echo div('desc', $foul->desc);

		echo div('link', 'Najděte si další '.$ren->link_for('fouls', 'fauly').'.');
	close('div');

	echo span('cleaner', '');
close('div');
