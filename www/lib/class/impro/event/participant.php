<?

namespace Impro\Event
{
	class Participant extends \System\Model\Database
	{
		static protected $attrs = array(
			"type" => array("int", "is_unsigned" => true, "default" => Participant\Type::ID_COMMON),
			"name" => array("varchar", "is_null" => true),
		);

		static protected $belongs_to = array(
			"event"  => array("model" => "\Impro\Event", "is_natural" => true),
			"player" => array("model" => "\Impro\Team\Member", "is_natural" => true),
		);


		public static function get_available_types()
		{
			return self::$types_available;
		}
	}
}
