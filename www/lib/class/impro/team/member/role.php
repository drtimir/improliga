<?

namespace Impro\Team\Member
{
	abstract class Role
	{
		const ID_MEMBER  = 1;
		const ID_MANAGER = 2;
		const ID_TRAINER = 3;
		const ID_PLAYER  = 4;
		const ID_FAN     = 5;


		const PERM_TEAM_DATA       = 1;
		const PERM_TEAM_EVENTS     = 2;
		const PERM_TEAM_DISCUSSION = 3;


		private static $types_available = array(
			self::ID_MEMBER  => 'impro_team_member',
			self::ID_MANAGER => 'impro_team_member_manager',
			self::ID_TRAINER => 'impro_team_member_trainer',
			self::ID_PLAYER  => 'impro_team_member_player',
			self::ID_FAN     => 'impro_team_member_fan',
		);


		private static $perms = array(
			self::PERM_TEAM_DATA       => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_EVENTS     => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_DISCUSSION => array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MEMBER, self::ID_PLAYER),
		);


		private static $roles_default = array(self::ID_PLAYER, self::ID_MEMBER);
		private static $types_manager = array(self::ID_MANAGER, self::ID_TRAINER);


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


		public static function get_manager_roles()
		{
			return self::$types_manager;
		}


		public static function has_right($role, $perm_id)
		{
			if (isset(self::$perms[$perm_id])) {
				return in_array($role, self::$perms[$perm_id]);
			} else throw new \System\Error\Argument(sprintf('Invalid permission id "%s"', $perm_id));
		}


		public static function get_default_roles()
		{
			return self::$roles_default;
		}
	}
}
