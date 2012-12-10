<?

namespace Impro
{
	class Team extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"       => array("varchar"),
			"name_full"  => array("varchar"),
			"about"      => array("text"),
			"site"       => array("varchar"),
			"played"     => array("int", "is_unsigned" => true),
			"visible"    => array("bool"),
		);


		protected static $has_one = array(
			"master" => array("model" => "\System\User"),
		);

		protected static $has_many = array(
			"players" => array("model" => "\System\User", "is_bilinear" => true, "is_master" => true),
		);


		public function count_players()
		{
			return $this->players->count();
		}


		public function get_name()
		{
			return $this->name.' - '.$this->name_full;
		}
	}
}
