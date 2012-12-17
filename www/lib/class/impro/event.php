<?

namespace Impro
{
	class Event extends \System\Model\Database
	{
		protected static $attrs = array(
			"id_impro_event_type" => array("int", "is_unsigned" => true, "default" => Event\Type::ID_SHOW),
			"title"         => array('varchar'),
			"image"         => array('image'),
			"desc_short"    => array('text'),
			"desc_full"     => array('text'),
			"visible"       => array('bool'),
			"start"         => array('datetime'),
			"duration"      => array("int", "is_unsigned" => true, "default" => 0),
			"published"     => array('bool'),
			"publish_at"    => array('datetime', "is_null" => true),
		);


		protected static $has_many = array(
			"participants" => array("model" => '\Impro\Event\Participant'),
			"teams"        => array("model" => '\Impro\Team', "is_bilinear" => true),
		);


		protected static $belongs_to = array(
			"author"    => array("model" => "\System\User"),
			"team_home" => array("model" => '\Impro\Team', "is_null" => true),
			"team_away" => array("model" => '\Impro\Team', "is_null" => true),
		);


		public static function get_available_types()
		{
			return self::$types_available;
		}
	}
}
