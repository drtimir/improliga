<?

if (preg_match("/^intra/", $_SERVER['HTTP_HOST'])) {

	if ($request->logged_in()) {
		if (!$request->user()->first_name) {
			$path_logout   = \System\Router::get_url($request->host, 'logout');

			if ($request->path != $path_logout) {
				$path_settings = \System\Router::get_url($request->host, 'profile_settings');

				if ($request->path != $path_settings) {
					redirect_now($path_settings.'?message=1');
				}
			}
		}

		\Impro\User::load_members($request->user());

	} else {
		if (strpos($request->path, '/user/request/') !== 0) {
			$login_path = \System\Router::get_url($request->host, 'login');
			if ($request->path != $login_path) {
				redirect_now($login_path.'?redirect='.$request->path);
			}
		}
	}
}
