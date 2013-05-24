<?

if (preg_match("/^intra/", $_SERVER['HTTP_HOST'])) {

	if ($request->logged_in()) {
		\Impro\User::load_members($request->user());

	} else {
		$login_path = \System\Router::get_url($request->host, 'login');
		if ($request->path != $login_path) {
			redirect_now($login_path.'?redirect='.$request->path);
		}
	}
}
