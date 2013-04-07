<?

namespace Impro\Team
{
	class Member extends \System\Model\Database
	{
		protected static $attrs = array(
			"roles"  => array("int_set"),
			"active" => array("bool"),
		);


		protected static $belongs_to = array(
			"team" => array("model" => "\Impro\Team", "is_natural" => true),
			"user" => array("model" => "\System\User", "is_natural" => true),
		);


		public function get_name($pattern = null)
		{
			return $this->user->get_name($pattern);
		}


		public function get_roles()
		{
			$roles = array();
			foreach ($this->roles as $role) {
				$roles[] = \Impro\Team\Member\Role::get_name($role);
			}

			return $roles;
		}


		public function to_html($link_team)
		{
			return div('team_member', array(
				link_for(\Stag::img(array("src" => $this->team->logo->thumb_trans(56, 38))), soprintf($link_team, $this->team)),
				div('team_member_info', array(
					$this->team->to_html_link($link_team),
					div('roles', implode(', ', $this->get_roles())),
				)),
				div('cleaner', ''),
			));
		}


		public function to_html_member($link_user)
		{
			return div('team_user', array(
				link_for(\Stag::img(array("src" => $this->user->avatar->thumb_trans(56, 38))), soprintf($link_user, $this->user)),
				div('team_member_info', array(
					div('name', array(
						link_for($this->user->get_name(), soprintf($link_user, $this->user)),
					)),
					div('roles', implode(', ', $this->get_roles())),
				)),
			));
		}


		public static function get_manager_types()
		{
			return self::$types_managers;
		}
	}
}
