<?

namespace Impro\Gallery
{
	class Photo extends \System\Model\Database
	{
		protected static $attrs = array(
			"gallery" => array('belongs_to', "model" => "\Impro\Gallery"),
			"image"   => array('image'),
			"desc"    => array('text'),
			"order"   => array('int', "default" => 0),
			"author"  => array('belongs_to', "model" => "\System\User"),
		);
	}
}
