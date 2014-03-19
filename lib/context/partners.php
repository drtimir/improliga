<?

$context = function($rq, $res) {
	return array(
		'partners' => get_all('Impro\Partner')->where(array('visible' => true))->fetch()
	);
};
