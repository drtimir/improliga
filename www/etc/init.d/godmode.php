<?

if (Godmode\Router::entered($request)) {
	Godmode\Router::init();

	if (!$request->logged_in()) {
		$url_login = \System\Router::get_url($request->host, 'god_login');

		if ($request->path != $url_login) {
			redirect_now($url_login);
		}
	}
}
