<?

echo ul('plain');

	foreach ($partners as $partner) {
		echo li($ren->link_ext($partner->site, Stag::span(array(
			"class" => 'icon isize-32',
			"style" => 'background-image:url('.$partner->image->thumb(32,32).'); height:32px;',
			"title" => $partner->name,
			"content" => $partner->name,
		))));
	}

close('ul');
