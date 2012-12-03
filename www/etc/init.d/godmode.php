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
	if ($t == 'godmode/window') {
		System\Flow::add('godmode/window/menu', array("slot" => 'menu'));
	}
}


System\Flow::add('core/menu/show', array(
	"menu-path"  => str_replace('god/', NULL, \System\Input::get('path')),
	"related"    => true,
	"class"      => 'admin-left-menu',
	"icon_size"  => 24,
	"type"       => 'admin-menu',
	"slot"       => 'left',
));


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
