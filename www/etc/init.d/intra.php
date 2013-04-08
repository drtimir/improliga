<?


if (!System\User::logged_in()) {
	if (System\Page::get_path() != '/login/') {
		redirect_now('/login/');
	}
}

user()->members = get_all('\Impro\Team\Member')->where(array("id_system_user" => user()->id))->fetch();
$teams = array();

foreach (user()->members as $mem) {
	$teams[] = $mem->team;
}

user()->teams = $teams;



content_for('scripts', 'lib/html5');


