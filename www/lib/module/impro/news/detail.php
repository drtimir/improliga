<?

$this->req('id');

def($link_cont, '/novinky/{seoname}');
def($link_author, '');
def($display_author, false);

if ($id && $item = find('\Impro\News', $id)) {

	$this->template('impro/news/detail', array(
		"item" => $item,
		"display_author" => $display_author,
		"link_cont" => $link_cont,
		"link_author" => $link_author,
	));

	$propagate['news'] = $item->id;

} else throw new \System\Error\NotFound();
