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
			"chapters" => array("model" => '\Impro\Article\Chapter', "foreign_name" => 'id_article'),
		);

		protected static $belongs_to = array(
			"category" => array("model" => '\Impro\Article\Category'),
		);
	}
}
