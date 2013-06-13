<?

$this->req('id');

if (isset($propagated['team']) && $team = $propagated['team']) {

	if ($team->use_attendance) {

		$member = $team->member($request->user());
		if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ATTENDANCE)) {
			if ($training = find('\Impro\Team\Training', $id)) {

				$acks = $training->acks->sort_by('status')->fetch();
				$this->partial('impro/team/attendance/training', array(
					"member"   => $member,
					"team"     => $team,
					"training" => $training,
					"acks"     => $acks,
				));
			} else throw new \System\Error\NotFound();
		} else throw new \System\Error\AccessDenied();
	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
