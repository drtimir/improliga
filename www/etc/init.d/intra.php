<?

if (preg_match("/^intra/", $_SERVER['HTTP_HOST'])) {
	if ($request->logged_in()) {
		if ($request->path != '/login/') {
			redirect_now('/login/');
		}
	}

	$request->user()->members = get_all('\Impro\Team\Member')->where(array("id_system_user" => $request->user()->id))->fetch();
	$teams = array();

	foreach ($request->user()->members as $mem) {
		$teams[] = $mem->team;
	}

	$request->user()->teams = $teams;
}
