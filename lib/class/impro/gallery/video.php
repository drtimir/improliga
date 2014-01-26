<?

namespace Impro\Gallery
{
	class Video extends \System\Model\Database
	{
		protected static $attrs = array(
			"gallery"  => array('belongs_to', "model" => "\Impro\Gallery"),
			"snapshot" => array('image'),
			"src"      => array('varchar'),
			"desc"     => array('text'),
			"order"    => array('int', "default" => 0),
			"youtube"  => array('bool', "default" => false),
			"author"   => array('belongs_to', "model" => "\System\User"),
		);
	}
}
