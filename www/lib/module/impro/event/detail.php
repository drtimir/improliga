<?

def($id);
def($link_cont, '/events/{id_impro_event}/');
def($conds, array());
def($opts, array());
def($template, 'impro/event/detail');

if ($id && $item = find('\Impro\Event', $id)) {

	title($item->title);

	$this->template($template, array(
		"event" => $item,
	));

} else throw new System\Error\NotFound();
