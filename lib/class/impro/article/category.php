<?

namespace Impro\Article
{
	class Category extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"     => array('varchar'),
			"weight"   => array('int', "is_unsigned" => true),
			"visible"  => array('bool'),
			"articles" => array('has_many', "model" => '\Impro\Article'),
		);
	}
}
