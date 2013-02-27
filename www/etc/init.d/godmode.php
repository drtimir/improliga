<?

require_once ROOT.'/etc/init.d/session.php';

System\Init::full();

Godmode\Router::init();


$page = Godmode\Router::page();
if (!($page instanceof System\Page)) {
	throw new System\Error\NotFound();
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
exit;
System\Message::dequeue_all();
