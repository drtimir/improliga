<?

require_once ROOT.'/etc/init.d/session.php';

System\Init::full();
System\Cache::init();
System\Database::init();
System\Output::init();
System\Page::init();

if (!System\User::logged_in()) {
	if (System\Input::get('path') != '/intra/login/') {
		System\Flow::redirect_now(array("url" => '/login/', "code" => 302));
	}
}


if (!(($page = System\Page::get_current()) instanceof System\Page)) {
	System\Status::recoverable_error(404);
}

if (!$page->is_readable()) {
	System\Status::recoverable_error(403);
}


function intra_path()
{
	$p = explode('/', \System\Input::get('path'));
	unset($p[1]);
	return implode('/', $p);
}

user()->members = get_all('\Impro\Team\Member')->where(array("id_system_user" => user()->id))->fetch();
$teams = array();

foreach (user()->members as $mem) {
	$teams[] = $mem->team;
}

user()->teams = $teams;


content_for("meta", $page->get_meta());
System\Output::set_opts(array(
	"format"   => cfg("output", 'format_default'),
	"lang"     => System\Locales::get_lang(),
	"title"    => $page->title,
	"template" => $page->template,
	"page"     => $page->seoname,
));

System\Flow::run();
System\Flow::run_messages();

if (strpos($page->get_path(), "/cron") === 0) {
	System\Status::report("cron", "Requested cron page ".$page->get_path());
}

System\Output::out();
System\Message::dequeue_all();
