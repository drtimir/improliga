<?

namespace Impro
{
	class File extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"   => array("varchar"),
			"desc"   => array("varchar"),
			"author" => array('belongs_to', "model" => "System\User"),
			"public" => array('bool'),
		);
	}
}
