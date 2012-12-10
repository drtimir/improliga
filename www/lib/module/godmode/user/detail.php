<?

def($id);

if ($id && $user = find("\System\User", $id)) {
	$this->template('godmode/user/detail', array("user" => $user));
}
