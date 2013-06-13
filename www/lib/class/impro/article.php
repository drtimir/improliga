<?

namespace Impro
{
	class Article extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"      => array('varchar'),
			"category"  => array('belongs_to', "model" => 'Impro\Article\Category'),
			"desc"      => array('text'),
			"published" => array('bool'),
			"visible"   => array('bool'),
			"chapters"  => array('has_many', "model" => 'Impro\Article\Chapter', "foreign_name" => 'id_article'),
		);
	}
}
