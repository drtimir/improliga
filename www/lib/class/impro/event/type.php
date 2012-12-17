<?

namespace Impro\Event
{
	class Type
	{
		const ID_SHOW       = 1;
		const ID_MATCH      = 2;
		const ID_LONG_FORM  = 3;
		const ID_MUSIC_FORM = 4;

		static private $types_available = array(
			'event_type'            => self::ID_MATCH,
			'event_type_show'       => self::ID_SHOW,
			'event_type_long_form'  => self::ID_LONG_FORM,
			'event_type_music_form' => self::ID_MUSIC_FORM,
		);
	}
}
