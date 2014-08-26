<?

$user = $request->user;
$data = array();

if ($user) {
	$data['status'] = 400;
	$data['msg']    = 'not-implemented';

} else {
	$data['status'] = 403;
	$data['msg']    = 'must-be-logged-in';
}

$this->partial(null, $data);
