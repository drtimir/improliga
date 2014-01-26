<?

namespace Impro\Event
{
	class Participant extends \System\Model\Database
	{
		static protected $attrs = array(
			"event"  => array('belongs_to', "model" => "Impro\Event"),
			"player" => array('belongs_to', "model" => "Impro\Team\Member"),
			"type"   => array("int", "is_unsigned" => true, "default" => Participant\Type::ID_COMMON),
			"name"   => array("varchar", "is_null" => true),
		);


		public static function get_available_types()
		{
			return self::$types_available;
		}
	}
}
