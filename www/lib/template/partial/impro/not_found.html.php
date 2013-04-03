<?

Tag::div(array("class" => 'page-block'));

	Tag::div(array("class" => array('block', 'left', 'layout_34')));
		echo section_heading('Stránka nenalezena');
		Tag::p(array("content" => 'Stránka, kterou jste hledali neexistuje. Pravděpodobně vám někdo poslal starý nebo špatný odkaz.'));
		Tag::p(array("content" => 'Ale to přece nevadí, my máme stránek hrozně moc.'));
		Tag::ul();
			Tag::li(array("content" => link_for('Události', '/udalosti/').' - Přijďte se podívat na některé z představeí našich týmů'));
			Tag::li(array("content" => link_for('Týmy', '/tymy/').' - Projďete si seznam našich týmů'));
			Tag::li(array("content" => link_for('O Improlize', '/o-improlize/').' - Přečtěte si něco o České Improlize'));
			Tag::li(array("content" => link_for('Kontakty', '/kontakty/').' - Napište nám'));
		close('ul');
	close('div');

	Tag::div(array("class" => array('block', 'right', 'layout_14')));
		$foul = \Impro\Foul::get_random();

		echo heading($foul->name);
		echo div('desc', $foul->desc);

		echo div('link', 'Najděte si další '.link_for('fauly', '/o-improlize/fauly/').'.');
	close('div');

	Tag::span(array("class" => 'cleaner', "close" => true));
close('div');
