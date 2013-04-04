<?

Tag::ul(array("class" => 'plain'));

	foreach ($partners as $partner) {
		Tag::li(array(
			"content" => link_for(Stag::span(array(
				"class" => 'icon isize-32',
				"style" => 'background:url('.$partner->image->thumb_trans(32,32).'); height:32px; width:32px;',
				"title" => $partner->name,
			)), $partner->site)
		));
	}

close('ul');
