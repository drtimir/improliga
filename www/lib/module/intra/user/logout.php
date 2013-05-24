<?

$request->user()->logout();
$flow->redirect($ren->url('home'));
