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


		public function to_html(\System\Template\Renderer $ren)
		{
			return div('team_member', array(
				$ren->link_for('team', $this->team->logo->to_html(56, 38), args($this->team)),
				div('team_member_info', array(
					$this->team->to_html_link($ren),
					div('roles', implode(', ', $this->get_roles())),
				)),
				div('cleaner', ''),
			));
		}


		public function to_html_member(\System\Template\Renderer $ren)
		{
			return div('team_user', array(
				\Impro\User::avatar($ren, $this->user, 56, 38),
				div('team_member_info', array(
					div('name', array(
						\Impro\User::link($ren, $this->user),
					)),
					div('roles', implode(', ', $this->get_roles())),
				)),
			));
		}


		public static function get_manager_types()
		{
			return self::$types_managers;
		}


		public function has_right($perm_id)
		{
			foreach ($this->roles as $role) {
				if (\Impro\Team\Member\Role::has_right($role, $perm_id)) {
					return true;
				}
			}

			return false;
		}
	}
}
