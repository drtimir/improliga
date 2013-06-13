<?

$this->req('id');

if (isset($propagated['team']) && $team = $propagated['team']) {
	if ($team->use_attendance) {
		$member = $team->member($request->user());
		if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ATTENDANCE)) {
			if ($training = find('\Impro\Team\Training', $id)) {

				$ack = $training->acks->where(array("id_user" => $request->user()->id))->fetch_one();

				if (!$ack) {
					$ack = new \Impro\Team\Training\Ack(array(
						"training" => $training,
						"count"    => 1,
						"user"     => $request->user(),
						"member"   => $member,
					));
				}

				$default = $ack->get_data();
				$default['guests'] = $ack->count - 1;
				$f = $ren->form(array(
					"heading" => $locales->trans('intra_team_attd_ack_response', $ren->format_date($training->start, 'human-date')),
					"default" => $default,
				));

				$f->input(array(
					"name"     => 'status',
					"type"     => 'select',
					"required" => true,
					"label"    => $locales->trans('intra_team_attd_ack_response_status'),
					"options"  => \Impro\Team\Training\Ack::get_responses($ren),
				));
				$f->input_number('guests', $locales->trans('intra_team_attd_ack_guests'));
				$f->submit($locales->trans('godmode_save'));

				$f->out($this);

				if ($f->passed()) {
					$p = $f->get_data();

					if (any($p['guests']) && $p['guests'] > 0) {
						$p['count'] = $p['guests'] + 1;
					}

					$ack->update_attrs($p);

					if ($ack->status != \Impro\Team\Training\Ack::RESPONSE_YES) {
						$ack->count = 0;
					}

					$ack->save();
					$flow->redirect($ren->url('team_attendance', array($team)));
				}


			} else throw new \System\Error\NotFound();
		} else throw new \System\Error\AccessDenied();
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
