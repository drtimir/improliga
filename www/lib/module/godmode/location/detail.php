<?

def($id);

if ($id && $item = find("\System\Location", $id)) {
	$this->template("godmode/location/detail", array("item" => $item));
} else throw new \System\Error\NotFound();

