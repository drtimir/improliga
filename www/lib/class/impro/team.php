<?

namespace Impro
{
	class Team extends \System\Model\Database
	{
		protected static $attrs = array(
			"name_short" => array("varchar"),
			"name_full"  => array("varchar"),
			"about"      => array("text"),
			"site"       => array("varchar"),
		);


		protected static $has_one = array(
			"master" => array("model" => "\System\User"),
		);

		protected static $has_many = array(
			"players" => array("model" => "\System\User", "is_bilinear" => true, "is_master" => true),
		);
	}
}
