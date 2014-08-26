<?

def($template, 'seo/team/detail');

$this->req('id');

$item = find('\Impro\Team', $id);

if ($id && $item && $item->published) {

	$this->partial($template, array(
		"event" => $item,
	));

} else throw new System\Error\NotFound();
