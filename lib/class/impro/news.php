<?

namespace Impro
{
	class News extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"      => array("varchar"),
			"text"      => array("html"),
			"visible"   => array("bool"),
			"published" => array("bool"),
			"author"    => array('belongs_to', "model" => 'System\User')
		);

		protected static $access = array(
			'schema' => true,
			'browse' => true,
		);
	}
}
