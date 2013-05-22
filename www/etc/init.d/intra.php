<?

if (preg_match("/^intra/", $_SERVER['HTTP_HOST'])) {

	if ($request->logged_in()) {
		$request->user()->members = get_all('\Impro\Team\Member')->where(array("id_system_user" => $request->user()->id))->fetch();
		$teams = array();

		foreach ($request->user()->members as $mem) {
			$teams[] = $mem->team;
		}

		$request->user()->teams = $teams;
	} else {
		$login_path = \System\Router::get_url($request->host, 'intra_login');
		if ($request->path != $login_path) {
			redirect_now($login_path);
		}
	}
}
