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
			self::ID_MEMBER        => 'impro-team-member',
			self::ID_MANAGER       => 'impro-team-member-manager',
			self::ID_TRAINER       => 'impro-team-member-trainer',
			self::ID_MARKETING     => 'impro-team-member-marketing',
			self::ID_FINANCIAL     => 'impro-team-member-financial',
			self::ID_PLAYER        => 'impro-team-member-player',
			self::ID_OCCASIONALIST => 'impro-team-member-player_occasional',
			self::ID_MUSICIAN      => 'impro-team_member-musician',
			self::ID_FAN           => 'impro-team-member-fan',
		);


		private static $perms = array(
			self::PERM_TEAM_DATA       => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_EVENTS     => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_DISCUSSION => array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MEMBER, self::ID_PLAYER),
			self::PERM_TEAM_ATTENDANCE => array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MEMBER, self::ID_PLAYER, self::ID_OCCASIONALIST),
			self::PERM_TEAM_ORGANIZE   => array(self::ID_MANAGER, self::ID_TRAINER),
			self::PERM_TEAM_MODERATE   => array(self::ID_MANAGER, self::ID_TRAINER),
		);


		private static $roles_default = array(self::ID_PLAYER, self::ID_MEMBER);
		private static $types_manager = array(self::ID_MANAGER, self::ID_TRAINER, self::ID_MARKETING);


		public static function get_all()
		{
			return self::$types_available;
		}


		public static function get_map()
		{
			$types = array();

			foreach (self::$types_available as $key=>$val) {
				$perms = array();

				foreach (self::$perms as $perm => $roles) {
					if (in_array($key, $roles)) {
						$perms[] = $perm;
					}
				}

				$types[$key] = array(
					"name"  => $val,
					"perms" => $perms,
				);
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
