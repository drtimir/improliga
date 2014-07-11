<?

$policy = function($rq, $res) {
	$rq->fconfig = array_merge_recursive($rq->fconfig, array(
		'team' => array(
			'member' => array(
				'roles' => \Impro\Team\Member\Role::get_map()
			)
		)
	));

	return true;
};
