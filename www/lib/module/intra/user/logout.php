<?

$request->user()->logout();
$flow->redirect($ren->url('intra_home'));
