<?

namespace Impro\Event\Participant
{
	class SIDE
	{
		const ID_NONE = 1;
		const ID_HOME = 2;
		const ID_AWAY = 3;

		static private $types_available = array(
			'event_participant_side_none' => self::ID_NONE,
			'event_participant_side_home' => self::ID_HOME,
			'event_participant_side_away' => self::ID_AWAY,
		);
	}
}
