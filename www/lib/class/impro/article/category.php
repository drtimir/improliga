<?

namespace Impro\Article
{
	class Category extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"weight"  => array('int', "is_unsigned" => true),
			"visible" => array('bool'),
		);


		protected static $has_many = array(
			"articles" => array("model" => '\Impro\Article', "foreign_name" => 'id_category'),
		);
	}
}
