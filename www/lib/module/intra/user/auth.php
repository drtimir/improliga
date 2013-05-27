<?

$this->req('uid');
$this->req('auth_key');

if ($code = \System\User\Auth\Code::validate($auth_key, $uid)) {

	if ($request->logged_in()) {
		if ($request->user()->id == $code->user->id) {
			$this->propagate('code', $code);
			$this->propagate('user', $code->user);
		} else throw new \System\Error\AccessDenied();
	} else redirect_now($ren->url('login'));
} else throw new \System\Error\AccessDenied();
