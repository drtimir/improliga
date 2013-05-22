<?

$this->req('id');

def($display_author, false);

if ($id && $item = find('\Impro\News', $id)) {

	$this->partial('impro/news/detail', array(
		"item" => $item,
		"display_author" => $display_author,
	));

	$propagate['news'] = $item->id;

} else throw new \System\Error\NotFound();
