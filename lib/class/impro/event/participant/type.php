<?

namespace Impro\Event\Participant
{
	class Type
	{
		const ID_COMMON            = 1;
		const ID_MANAGER           = 2;
		const ID_MC                = 3;
		const ID_REFEREE           = 4;
		const ID_REFEREE_HELPER    = 5;
		const ID_PLAYER            = 6;
		const ID_PLAYER_HOME       = 7;
		const ID_PLAYER_AWAY       = 8;
		const ID_MUSICIAN          = 9;
		const ID_TECHNICIAN_AUDIO  = 10;
		const ID_TECHNICIAN_LIGHTS = 11;


		static private $types_available = array(
			'event_participant'                   => self::ID_COMMON,
			'event_participant_manager'           => self::ID_MANAGER,
			'event_participant_mc'                => self::ID_MC,
			'event_participant_referee'           => self::ID_REFEREE,
			'event_participant_referee_helper'    => self::ID_REFEREE_HELPER,
			'event_participant_player'            => self::ID_PLAYER,
			'event_participant_player_away'       => self::ID_PLAYER_HOME,
			'event_participant_player_home'       => self::ID_PLAYER_AWAY,
			'event_participant_musician'          => self::ID_MUSICIAN,
			'event_participant_technician_audio'  => self::ID_TECHNICIAN_AUDIO,
			'event_participant_technician_lights' => self::ID_TECHNICIAN_LIGHTS,
		);
	}
}
