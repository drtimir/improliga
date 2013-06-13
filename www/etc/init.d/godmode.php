<?

if (Godmode\Router::entered($request)) {
	Godmode\Router::init();

	if ($request->logged_in()) {
		$pass = $request->user()->is_root();

		if (!$pass) {
			$groups = $request->user()->get_group_ids();
			$pass = in_array(1, $groups);
		}

		if (!$pass) {
			throw new \System\Error\AccessDenied();
		}

	} else {
		$url_login = \System\Router::get_url($request->host, 'god_login');

		if ($request->path != $url_login) {
			redirect_now($url_login);
		}
	}
}
