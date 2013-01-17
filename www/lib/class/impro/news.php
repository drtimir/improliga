<?

namespace Impro
{
	class News extends \System\Model\Database
	{
		protected static $attrs = array(
			"title"     => array("varchar"),
			"text"      => array("text"),
			"visible"   => array("bool"),
			"published" => array("bool"),
		);
	}
}
