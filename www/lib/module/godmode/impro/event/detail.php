<?

def($id);

if ($id && $item = find("\Impro\Event", $id)) {
	$this->template("godmode/impro/event/detail", array(
		"event" => $item
	));
}
