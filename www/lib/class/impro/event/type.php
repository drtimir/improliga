<?

namespace Impro\Event
{
	class Type
	{
		const ID_SHOW       = 1;
		const ID_MATCH      = 2;
		const ID_LONG_FORM  = 3;
		const ID_MUSIC_FORM = 4;
		const ID_WORKSHOP   = 5;

		static private $types_available = array(
			'impro_match'      => self::ID_MATCH,
			'impro_show'       => self::ID_SHOW,
			'impro_long_form'  => self::ID_LONG_FORM,
			'impro_music_form' => self::ID_MUSIC_FORM,
			'impro_workshop'   => self::ID_WORKSHOP,
		);


		public static function get_all()
		{
			$types = array();

			foreach (self::$types_available as $label=>$id) {
				$types[l($label)] = $id;
			}

			return $types;
		}


		public static function get_by_id($tid)
		{
			foreach (self::$types_available as $label=>$id) {
				if ($id === $tid) {
					return l($label);
				}
			}

			return null;
		}
	}
}
