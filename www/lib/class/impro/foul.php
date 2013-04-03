<?

namespace Impro
{
	class Foul extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"    => array('varchar'),
			"points"  => array('int', "default" => 0),
			"image"   => array('image', "default" => "/share/pixmaps/logo.png"),
			"desc"    => array('text'),
			"visible" => array('bool', "default" => false),
		);


		public static function get_random()
		{
			return get_first('\Impro\Foul')->sort_by('RAND()')->fetch();
		}
	}
}
