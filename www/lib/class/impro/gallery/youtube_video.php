<?

namespace Impro
{
	class YoutubeVideo extends \System\Model\Database
	{
		protected static $attrs = array(
			"snapshot" => array('image'),
			"src"      => array('varchar'),
			"desc"     => array('text'),
			"order"    => array('int', "default" => 0),
		);

		protected static $belongs_to = array(
			"author"  => array("model" => "\System\User"),
			"gallery" => array("model" => "\Impro\Gallery"),
		);
	}
}
