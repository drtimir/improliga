<?

if (Godmode\Router::entered($request)) {
	Godmode\Router::init();

	if (!$request->logged_in()) {
		if ($request->path != $request->url('god_login')) {
			redirect_now($request->url('god_login'));
		}
	}
}
