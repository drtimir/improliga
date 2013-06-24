<?

$ren->format = def($format, 'html');

$model_rq = get_model('Impro\User\Request');
$model_ne = get_model('Impro\User\Notice');


$conds = array(
	"read" => false,
	"id_user" => $request->user()->id
);

$requests = get_all($model_rq)->where($conds)->sort_by('created_at')->fetch();
$notices  = get_all($model_ne)->where($conds)->sort_by('created_at')->fetch();

$status = array(
	"requests" => array(),
	"notices"  => array(),
);

foreach ($requests as $rq) {
	$status['requests'][] = array(
		"author" => $rq->id_author,
		"team"   => $rq->id_team,
		"text"   => $rq->text,
		"link"   => $ren->url('request', array($rq->code->uid, $rq->id, $rq->code->key)),
		"created_at" => $rq->created_at->getTimestamp(),
	);
}

foreach ($notices as $ne) {
	$status['notices'][] = array(
		"author" => $ne->id_author,
		"team"   => $ne->id_team,
		"text"   => $ne->text,
		"link"   => $ne->redirect,
		"created_at" => $rq->created_at->getTimestamp(),
	);

	$ne->read = true;
	$ne->save();
}


$this->partial('impro/user/status/detail', array(
	"status" => $status,
));

