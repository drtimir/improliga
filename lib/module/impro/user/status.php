<?

$model_rq = get_model('Impro\User\Request');
$model_ne = get_model('Impro\User\Notice');

$conds = array(
	"read" => false,
	"id_user" => $request->user()->id
);

$last_rq = get_first($model_rq)->where($conds)->sort_by('created_at')->fetch();
$last_ne = get_first($model_ne)->where($conds)->sort_by('created_at')->fetch();

if ($last_rq || $last_ne) {
	if ($last_rq && !$last_ne) {
		$updated_at = $last_rq->created_at->getTimestamp();
	} elseif ($last_ne && !$last_rq) {
		$updated_at = $last_ne->created_at->getTimestamp();
	} else {
		$utime_rq = $last_rq->created_at->getTimestamp();
		$utime_ne = $last_ne->created_at->getTimestamp();
		$updated_at = $utime_rq > $utime_ne ? $utime_rq:$utime_rq;
	}
} else $updated_at = time();

$ren->format = 'json';
$this->partial('impro/user/status', array(
	"status" => array(
		'requests'   => get_all($model_rq)->where($conds)->count(),
		'notices'    => get_all($model_ne)->where($conds)->count(),
		'updated_at' => $updated_at,
	),
));
