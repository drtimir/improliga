<?

namespace Impro
{
	class News extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"      => array("varchar"),
			"text"      => array("text"),
			"visible"   => array("bool"),
			"published" => array("bool"),
			"author"    => array('belongs_to', "model" => 'System\User')
		);
	}
}
