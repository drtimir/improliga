<?

define("ROOT",  realpath(__DIR__.'/../www'));

$_SERVER['REQUEST_URI'] = '/intra'.$_SERVER['REQUEST_URI'];

require_once ROOT."/etc/init.d/core.php";
require_once ROOT."/etc/init.d/intra.php";

