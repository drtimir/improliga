<?

Tag::div(array("class" => array("detail", "detail-news")));

echo section_heading(link_for($item->name, soprintf($link_cont, $item)));

Tag::div(array(
	"class"   => 'text',
	"content" => array(
		Tag::div(array(
			"output"  => false,
			"content" => $item->text,
		))
	)
));

Tag::div(array(
	"class"   => 'footer',
	"content" => array(
		Tag::datetime(array("output" => false, "content" => format_date($item->created_at, 'human'))),
		Tag::a(array(
			"output"  => false,
			"class"   => 'author',
			"href"    => soprintf($link_author, $item),
			"content" => $item->author->get_name()
		)),
	)
));


Tag::close('div');
