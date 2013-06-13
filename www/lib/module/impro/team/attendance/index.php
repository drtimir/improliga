<?

def($partial_top,   'impro/team/attendance/header');
def($partial_table, 'impro/team/attendance/table');

if (isset($propagated['team']) && $team = $propagated['team']) {

	$member = $team->member($request->user());

	if ($member->has_right(\Impro\Team\Member\Role::PERM_TEAM_ATTENDANCE)) {

		$latest    = $team->trainings->where(array("start > NOW()"))->sort_by('start')->paginate(1, 0)->fetch_one();
		$trainings = $team->trainings->sort_by('start')->paginate(10, 0)->fetch();
		$members   = $team->members->fetch();

		$this->partial($partial_top, array(
			"team"   => $team,
			"latest" => $latest,
		));


		$this->partial($partial_table, array(
			"team"      => $team,
			"trainings" => $trainings,
			"members"   => $members,
		));

	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
