<?

namespace Impro
{
	class Partner extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('html'),
			"site"    => array('url'),
			"image"   => array('image'),
			"clicked" => array('int', "is_unsigned" => true),
			"visible" => array('bool'),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true
		);


		public static function visible()
		{
			return get_all('\Impro\Partner')->where(array("visible" => true))->sort_by('clicked desc');
		}
	}
}
