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
			self::ID_MEMBER  => 'team_member',
			self::ID_MANAGER => 'team_member_manager',
			self::ID_TRAINER => 'team_member_trainer',
			self::ID_PLAYER  => 'team_member_player',
			self::ID_FAN     => 'team_member_fan',
		);


		public static function get_all()
		{
			$types = array();

			foreach (self::$types_available as $key=>$val) {
				$types[l($key)] = $val;
			}

			return $types;
		}
	}
}
