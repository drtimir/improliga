<?

namespace Impro\Event
{
	class Participant extends \System\Model\Database
	{
		static protected $attrs = array(
			"id_impro_event_participant_type" => array("int", "is_unsigned" => true, "default" => Participant\Type::ID_COMMON),
			"id_impro_event_participant_side" => array("int", "is_unsigned" => true, "default" => Participant\Side::ID_NONE),
			"name" => array("varchar", "is_null" => true),
		);

		static protected $belongs_to = array(
			"event"  => array("model" => "\Impro\Event", "is_natural" => true),
			"team"   => array("model" => "\Impro\Team", "is_natural" => true),
			"player" => array("model" => "\System\User", "is_natural" => true),
		);


		public static function get_available_types()
		{
			return self::$types_available;
		}
	}
}
