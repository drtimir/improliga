<?

require_once ROOT.'/etc/init.d/session.php';

System\Init::full();

if (!System\User::logged_in()) {
	if (System\Input::get('path') != '/god/login/') {
		System\Flow::redirect_now(array("url" => '/god/login', "code" => 302));
	}
}


Godmode\Page::init();
$page = Godmode\Page::fetch();
if (!($page instanceof System\Page)) {
	System\Status::recoverable_error(404);
}

foreach ($page->template as $t) {
	if ($t == 'pwf/godmode/window') {
		System\Flow::add('godmode/window/menu', array("slot" => 'menu'));
		break;
	}
}


System\Output::set_title(System\Output::introduce(), l('GodMode'));
System\Output::set_opts(array(
	"format" => 'html',
	"lang" => 'cs',
	"title" => $page->title,
	"template" => $page->template,
));

System\Flow::run();
System\Flow::run_messages();

System\Output::out();
System\Message::dequeue_all();
