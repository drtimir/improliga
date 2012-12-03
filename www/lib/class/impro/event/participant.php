<?

namespace Impro\Event
{
	class Participant extends \System\Model\Database
	{
		const ID_TYPE_PARTICIPANT      = 1;
		const ID_TYPE_TEAM_HOME        = 2;
		const ID_TYPE_TEAM_AWAY        = 3;
		const ID_TYPE_USER_PARTICIPANT = 4;


		static private $types_available = array(
			'event_participant_plain'     => self::ID_TYPE_PARTICIPANT,
			'event_participant_team_home' => self::ID_TYPE_TEAM_HOME,
			'event_participant_team_away' => self::ID_TYPE_TEAM_AWAY,
			'event_participant_user'      => self::ID_TYPE_USER_PARTICIPANT,
		);


		static protected $attrs = array(
			"id_impro_event_participant_type" => array("int", "is_unsigned" => true, "default" => self::ID_TYPE_PARTICIPANT),
			"name" => array("varchar", "is_null" => true),
		);

		static protected $belongs_to = array(
			"event"  => array("model" => "\Impro\Event"),
			"team"   => array("model" => "\Impro\Team"),
			"player" => array("model" => "\System\User"),
		);


		public static function get_available_types()
		{
			return self::$types_available;
		}
	}
}
