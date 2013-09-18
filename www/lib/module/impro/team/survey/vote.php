<?

$this->req('id');
$this->req('id_ans');

if ($sur = find('Impro\Team\Survey', $id)) {
	if ($ans = $sur->answers->where(array('id_impro_team_survey_answer' => $id_ans))->fetch_one()) {

		if ($ans->voted($request->user)) {
		} else {
			$ans->vote($request->user);
		}

		$response->redirect($ren->url('team', array($sur->team)));
	} else throw new \System\Error\NotFound();
} else throw new \System\Error\NotFound();
