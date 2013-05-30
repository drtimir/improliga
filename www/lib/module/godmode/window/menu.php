<?

def($model);

$this->partial("godmode/window/menu", array(
	"options" => \Godmode\Router::get_window_menu($request, $ren),
	"model"   => $model,
));

