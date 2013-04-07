<?

namespace Impro\Team\Member
{
	class Role
	{
		const ID_MEMBER  = 1;
		const ID_MANAGER = 2;
		const ID_TRAINER = 3;
		const ID_PLAYER  = 4;
		const ID_FAN     = 5;

		private static $types_available = array(
			self::ID_MEMBER  => 'impro_team_member',
			self::ID_MANAGER => 'impro_team_member_manager',
			self::ID_TRAINER => 'impro_team_member_trainer',
			self::ID_PLAYER  => 'impro_team_member_player',
			self::ID_FAN     => 'impro_team_member_fan',
		);


		private static $types_managers = array(self::ID_MANAGER, self::ID_TRAINER);


		public static function get_all()
		{
			$types = array();

			foreach (self::$types_available as $key=>$val) {
				$types[l($key)] = $val;
			}

			return $types;
		}


		public static function get_name($id)
		{
			if (isset(self::$types_available[$id])) {
				return l(self::$types_available[$id]);
			}
		}
	}
}
