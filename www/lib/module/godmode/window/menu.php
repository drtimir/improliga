<?

$path = substr(System\Input::get('path'), 5);
$options = array();

$menu = \Godmode\Menu::create(array(
	"type"      => 'admin-menu',
	"menu-path" => $path,
));

$this->template("godmode/window/menu", array(
	"path"    => $path,
	"options" => $menu->get_items(),
));

