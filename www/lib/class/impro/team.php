<?

namespace Impro
{
	class Team extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"       => array("varchar"),
			"name_full"  => array("varchar"),
			"city"       => array("varchar", "default" => ''),
			"about"      => array("text", "default" => ''),
			"logo"       => array('image', "default" => "/share/pixmaps/logo_original.png"),
			"photo"      => array('image', "default" => "/share/pixmaps/impro/team.png"),
			"site"       => array("varchar", "default" => ''),
			"played"     => array("int", "is_unsigned" => true, "default" => 0),
			"visible"    => array("bool"),
		);

		protected static $belongs_to = array(
			"author" => array("model" => "\System\User"),
			"hq"     => array("model" => "\System\Location"),
		);

		protected static $has_many = array(
			"members"   => array("model" => "\Impro\Team\Member"),
			"galleries" => array("model" => '\Impro\Gallery', "is_bilinear" => true),
		);


		public function count_members()
		{
			return $this->members->count();
		}
	}
}
