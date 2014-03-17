<?

echo div('foul-detail');

	echo section_heading($item->name);
	echo div('desc', \System\Template::to_html($item->desc));

close('div');
