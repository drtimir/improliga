<?

echo heading($item->title);

Tag::div(array(
	"class"   => "detail-team",
	"content" => array(
		Tag::div(array(
			"output"  => false,
			"content" => $item->text,
		))
	)
));
