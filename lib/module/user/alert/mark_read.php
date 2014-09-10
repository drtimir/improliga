<?

$ids = array_map('intval', $request->get('ids'));
$data = array();

if (is_array($ids) && any($ids)) {
	$alerts = get_all('Impro\User\Alert')->where(array('id' => $ids, 'id_user' => $request->user->id))->fetch();

	foreach ($alerts as $alert) {
		$alert->read = true;
		$alert->save();
	}

	$data['status'] = 200;
	$data['msg']    = 'saved';
} else {
	$data['status'] = 400;
	$data['msg']    = 'must-send-valid-ids';
}

$this->partial(null, $data);
