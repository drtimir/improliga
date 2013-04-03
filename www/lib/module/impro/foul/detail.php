<?

$this->req('id');

def($template, 'impro/foul/detail');

if ($id && ($item = find('\Impro\Foul', $id))) {

	$this->template($template, array(
		"item" => $item,
	));

} else throw new \System\Error\NotFound();
