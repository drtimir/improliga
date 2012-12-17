<?

namespace Impro\Event\Participant
{
	class Type
	{
		const ID_COMMON  = 1;
		const ID_MANAGER = 2;
		const ID_MC      = 3;
		const ID_REFEREE = 4;
		const ID_PLAYER  = 5;

		static private $types_available = array(
			'event_participant'         => self::ID_COMMON,
			'event_participant_manager' => self::ID_MANAGER,
			'event_participant_mc'      => self::ID_MC,
			'event_participant_referee' => self::ID_REFEREE,
			'event_participant_player'  => self::ID_PLAYER,
		);
	}
}
