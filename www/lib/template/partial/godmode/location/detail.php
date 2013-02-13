<?

echo heading($item->name);

Tag::div(array(
	"class"   => 'static-text',
	"content" => array(
		$item->addr,
		'<br>',
		Tag::a(array("href" => $item->url, "output" => false, "content" => $item->url)),
	)
));

echo $item->map_html();
