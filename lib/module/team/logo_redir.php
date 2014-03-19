<?

$this->req('id');


if ($id && $team = find('\Impro\Team', $id)) {

	if ($request->get('size')) {
		$size = explode('x', $request->get('size'));
		$flow->redirect($team->logo->thumb_trans($size[0], $size[1], true));
	} else {
		$flow->redirect($team->logo->get_path());
	}

} else throw new \System\Error\NotFound();
