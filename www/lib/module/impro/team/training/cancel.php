<?

def($new, false);
$this->req('id');

$model = '\Impro\Team\Training';

if (isset($propagated['team']) && $team = $propagated['team']) {

	if ($team->use_attendance) {

		$member = $team->member($request->user());
		if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ORGANIZE)) {

			if ($item = find($model, $id)) {

				$f = $ren->form_checker(array(
					"heading" => $ren->trans('training_cancel_heading'),
					"desc" => $ren->trans('training_cancel_desc'),
					"submit" => $ren->trans('training_cancel'),
					"default" => array(
						"drop" => true
					),
					"info" => array(
						$ren->trans('training_time') => $ren->format_date($item->start, 'human'),
					),
				));

				$f->input(array(
					"name"  => 'drop',
					"type"  => 'submit',
					"class" => 'gray',
					"label" => $ren->trans('training_delete')
				));

				$f->out();

				if ($f->passed()) {
					$p = $f->get_data();
					$drop = any($p['drop']);

					$item->cancel($ren, $drop);

					if ($drop) {
						$flow->redirect($ren->url('team_attendance', array($team)));
					} else {
						$flow->redirect($ren->url('team_training', array($team, $item)));
					}
				}
			} else throw new \System\Error\NotFound();
		} else throw new \System\Error\AccessDenied();
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
