<?

define("ROOT",  realpath(__DIR__.'/../www'));

if (strpos($_SERVER['REQUEST_URI'], '/api') !== 0) {
	$_SERVER['REQUEST_URI'] = '/intra'.$_SERVER['REQUEST_URI'];
}

require_once ROOT."/etc/init.d/core.php";
require_once ROOT."/etc/init.d/intra.php";

