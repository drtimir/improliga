<?

echo heading($text->name);

Tag::div(array(
	"class"   => 'static-text',
	"content" => $text->text,
));
