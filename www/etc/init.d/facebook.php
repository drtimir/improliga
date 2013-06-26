<?

if (!function_exists('curl_init')) {
	throw new \System\Error\Wtf('Facebook needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
	throw new \System\Error\Wtf('Facebook needs the JSON PHP extension.');
}

$request->facebook = new \Helper\Social\Facebook(array(
	'appId'  => cfg('facebook', 'app_id'),
	'secret' => cfg('facebook', 'app_secret'),
));

if ($request->facebook->logged_in()) {

	$request->facebook->update();
	$account = $request->facebook->get_account();

	if ($account->user) {
		$account->user->create_session($request);
	}

} else {

	$url = $request->facebook->getLoginUrl(array(
		"scope" => implode(', ', cfg('facebook', 'scope')),
		"redirect_uri" => 'http://'.$request->host.$request->path,
	));

	redirect_now($url);

}
