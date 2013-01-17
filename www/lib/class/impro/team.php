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

		protected static $belongs_to = array(
			"author" => array("model" => "\System\User"),
		);

		protected static $has_many = array(
			"members"   => array("model" => "\Impro\Team\Member"),
			"galleries" => array("model" => '\Impro\Gallery', "is_bilinear" => true),
		);


		public function count_members()
		{
			return $this->members->count();
		}


		public function get_name()
		{
			return $this->name.' - '.$this->name_full;
		}
	}
}
