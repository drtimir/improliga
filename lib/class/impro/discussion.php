<?

namespace Impro
{
	abstract class Discussion
	{
		const GID_GODLIKE   = 1;
		const GID_ADMIN     = 2;
		const GID_MODERATOR = 5;
		const UID_ROOT      = 1;

		private static $admin_groups = array(self::GID_GODLIKE, self::GID_ADMIN, self::GID_MODERATOR);


		public static function is_managable(\System\User $user, $obj)
		{
			if ($user->id == self::UID_ROOT || $obj->id_author == $user->id) {
				return true;
			}

			$groups = $user->get_group_ids();

			foreach ($groups as $gid) {
				if (in_array($gid, self::$admin_groups)) {
					if ($obj->id_author != self::UID_ROOT || $user->id == self::UID_ROOT) {
						return true;
					}
				}
			}
		}
	}
}
