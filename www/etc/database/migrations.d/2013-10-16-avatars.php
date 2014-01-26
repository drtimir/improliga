<?

$users = get_all('\System\User')->fetch();

foreach ($users as $user) {
	if ($user->avatar) {
		$opts = $user->avatar->get_opts();

		if (empty($opts)) {
			if (strpos($user->avatar->path, '/') === 0) {
				$user->avatar->path = ROOT.$user->avatar->path;
				$user->save();
			}
		} else {
			if ($opts['file_path']) {
				$avatar = \System\Image::from_path(ROOT.$opts['file_path']);
				$user->avatar = $avatar;
			} else {
				$user->avatar = null;
			}

			try {
				$user->save();
			} catch(\Exception $e) {
				$user->avatar = null;
				$user->save();
			}
		}
	}
}
