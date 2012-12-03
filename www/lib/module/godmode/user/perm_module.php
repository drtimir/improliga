<?

if ($mod_path) {

	def($group_id, null);
	def($link_home, '/god/users/perms/{path}/');
	def($link_switch, '/god/users/perms/{path}/{group_id}/');

	$path = str_replace('::', '/', $mod_path);

	if (System\Module::exists($path)) {

		if ($group_id) {
			if ($group_id == 'public') {

			} else {
				if ($group = find('System\User\Group', $group_id)) {
					$conds = array(
						"type"    => 'module',
						"trigger" => $path,
						"id_system_user_group" => $group_id,
					);

					$perm = get_first('System\User\Perm')->where($conds)->fetch();
					$perm ?
						$perm->drop():
						($perm = create('System\User\Perm', $conds));

					redirect(stprintf($link_home, array("path" => $mod_path)));
				}
			}
		}

		$perms = get_all('System\User\Perm')->where(array("type" => 'module', "trigger" => $path))->fetch();
		$groups = get_all('System\User\Group')->fetch();
		$groups_perm = array();

		foreach ($perms as $perm) {
			$groups_perm[] = $perm->id_system_user_group;
		}


		$this->template('godmode/user/perm_module', array(
			"link_switch" => $link_switch,
			"path"   => $mod_path,
			"perms"  => $perms,
			"groups" => $groups,
			"groups_perm" => $groups_perm,
		));
	}
}
