<?

def($id);

if ($id && $text = find("\System\Text", $id)) {
	$this->template("godmode/text/detail", array("text" => $text));
}

