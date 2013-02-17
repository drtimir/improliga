<?

namespace Impro
{
	class Article extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"      => array('varchar'),
			"desc"      => array('text'),
			"published" => array('bool'),
			"visible"   => array('bool'),
		);

		protected static $has_many = array(
			"chapters" => array("model" => '\Impro\Article\Chapter'),
		);
	}
}
