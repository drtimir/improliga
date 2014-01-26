<?

namespace Impro\User\Request
{
	class JoinTeam implements \Impro\User\Request\Callback
	{
		public static function yes(\Impro\User\Request $req)
		{
			$members = get_all('\Impro\Team\Member')->where(array(
				"id_impro_team" => $req->team->id,
				"id_system_user" => $req->user->id,
			))->count();

			if (empty($members)) {
				$member = create('\Impro\Team\Member', array(
					"roles" => \Impro\Team\Member\Role::get_default_roles(),
					"active" => 1,
					"id_impro_team"  => $req->team->id,
					"id_system_user" => $req->user->id,
				));

				if ($member instanceof \Impro\Team\Member) {
					return true;
				} else return false;
			}

			return true;
		}


		public static function no(\Impro\User\Request $req)
		{
			return true;
		}


		public static function maybe(\Impro\User\Request $req)
		{
			return true;
		}
	}
}
