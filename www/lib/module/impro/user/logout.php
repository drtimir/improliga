<?

$request->user()->logout();

$request->facebook = new \Helper\Social\Facebook(array(
	'appId'  => cfg('facebook', 'app_id'),
	'secret' => cfg('facebook', 'app_secret'),
));

if ($request->facebook && $request->facebook->logged_in()) {
	$request->facebook->logout();
}

$flow->redirect($ren->url('home'));
