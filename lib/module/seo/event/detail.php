<?

def($template, 'seo/event/detail');

$this->req('id');

$item = find('\Impro\Event', $id);

if ($id && $item && $item->published) {

	$response->renderer()->title = $item->name;

	$this->partial($template, array(
		"event" => $item,
	));

} else throw new System\Error\NotFound();
