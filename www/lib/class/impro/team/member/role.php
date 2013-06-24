<?

namespace Impro\Team\Member
{
	abstract class Role
	{
		const ID_MEMBER        = 1;
		const ID_MANAGER       = 2;
		const ID_TRAINER       = 3;
		const ID_PLAYER        = 4;
		const ID_FAN           = 5;
		const ID_FINANCIAL     = 6;
		const ID_OCCASIONALIST = 7;
		const ID_MUSICIAN      = 8;
		const ID_MARKETING     = 9;

		const PERM_TEAM_DATA       = 1;
		const PERM_TEAM_EVENTS     = 2;
		const PERM_TEAM_DISCUSSION = 3;
		const PERM_TEAM_ATTENDANCE = 4;
		const PERM_TEAM_ORGANIZE   = 5;
		const PERM_TEAM_MODERATE   = 6;


		private static $types_available = array(
			self::ID_MEMBER        => 'impro_team_member',
			self::ID_MANAGER       => 'impro_team_member_manager',
			self::ID_TRAINER       => 'impro_team_member_trainer',
			self::ID_MARKETING     => 'impro_team_member_marketing',
			self::ID_FINANCIAL     => 'impro_team_member_financial',
			self::ID_PLAYER        => 'impro_team_member_player',
			self::ID_OCCASIONALIST => 'impro_team_member_player_occasional',
			self::ID_MUSICIAN      => 'impro_team_member_musician',
			self::ID_FAN           => 'impro_team_member_fan',
		);


		private static $perms = array(
			self::PERM_TEAM_DATA       => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_EVENTS     => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_DISCUSSION => array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MEMBER, self::ID_PLAYER),
			self::PERM_TEAM_ATTENDANCE => array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MEMBER, self::ID_PLAYER),
			self::PERM_TEAM_ORGANIZE   => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_MODERATE   => array(self::ID_MANAGER, self::ID_TRAINER),
		);


		private static $roles_default = array(self::ID_PLAYER, self::ID_MEMBER);
		private static $types_manager = array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MARKETING);


		public static function get_all()
		{
			$types = array();

			foreach (self::$types_available as $key=>$val) {
				$types[$key] = $val;
			}

			return $types;
		}


		public static function get_name($id)
		{
			if (isset(self::$types_available[$id])) {
				return self::$types_available[$id];
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
