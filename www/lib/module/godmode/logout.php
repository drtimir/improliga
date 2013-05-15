<?

$request->user()->logout();
$flow->redirect($request->url('god_home'));
