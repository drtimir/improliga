<?

$this->req('id');


if ($id && $user = find('\System\User', $id)) {

	if ($request->get('size')) {
		$size = explode('x', $request->get('size'));
		$flow->redirect($user->avatar->thumb_trans($size[0], $size[1], true));
	} else {
		$flow->redirect($user->avatar->get_path());
	}

} else throw new \System\Error\NotFound();
