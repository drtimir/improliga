<?

namespace Impro
{
	class Gallery extends \System\Model\Database
	{
		protected static $attrs = array(
			"name" => array('varchar'),
			"desc" => array('text'),
		);

		protected static $has_many = array(
			"photos" => array("model" => '\Impro\Gallery\Photo'),
			"videos" => array("model" => '\Impro\Gallery\Video'),
		);

		protected static $belongs_to = array(
			"author" => array("model" => "\System\User"),
		);

	}
}
