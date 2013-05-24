<?

$request->user()->logout();
$flow->redirect($ren->url('god_home'));
