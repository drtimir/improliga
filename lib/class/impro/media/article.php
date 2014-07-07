<?

namespace Impro\Media
{
	class Article extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"      => array('varchar'),
			"publisher" => array('varchar'),
			"desc"      => array('html'),
			"url"       => array('url'),
			"date"      => array('date'),

			"visible"   => array('bool'),
			"published" => array('bool'),
		);

		protected static $access = array(
			"schema" => true,
			"browse" => true
		);
	}
}
