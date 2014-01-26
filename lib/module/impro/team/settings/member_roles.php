<?

$this->req('id');

if ($propagated['team']) {

	$team = &$propagated['team'];
	$member = $team->member($request->user());

	if ($member && $member->has_right(\Impro\Team\Member\Role::PERM_TEAM_DATA)) {
		$profile = find('\Impro\Team\Member', $id);
		$roles = \Impro\Team\Member\Role::get_all();
		$f = $ren->form(array(
			"heading" => $ren->trans('intra_team_member_add'),
			"class"   => 'intra_team_member_add',
			"default" => array("roles" => $profile->roles),
		));

		$f->input(array(
			"name"     => 'roles',
			"type"     => 'checkbox',
			"options"  => $roles,
			"label"    => $ren->trans('intra_team_member_roles'),
			"multiple" => true,
			"required" => true,
		));

		$f->submit($ren->trans('save'));

		if ($f->passed()) {
			$p = $f->get_data();

			$profile->roles = $p['roles'];
			$profile->save();

			$flow->redirect($ren->url('team_settings_members', array($team)));
		} else {
			$f->out($this);
		}

	} else throw new \System\Error\AccessDenied();
} else throw new \System\Error\NotFound();
