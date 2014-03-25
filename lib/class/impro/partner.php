<?

namespace Impro
{
	class Partner extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"desc"    => array('text'),
			"site"    => array('url'),
			"image"   => array('image'),
			"clicked" => array('int', "is_unsigned" => true),
			"visible" => array('bool'),
		);


		public static function visible()
		{
			return get_all('\Impro\Partner')->where(array("visible" => true))->sort_by('clicked desc');
		}
	}
}