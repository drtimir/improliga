<?

namespace Impro\Team
{
	class Member extends \System\Model\Perm
	{
		const ALLOW_RELATION_DELETE = true;

		protected static $attrs = array(
			"team"   => array('belongs_to', "model" => "Impro\Team", "is_natural" => true),
			"user"   => array('belongs_to', "model" => "System\User", "is_natural" => true),
			"roles"  => array("int_set", "options" => array(
				\Impro\Team\Member\Role::ID_MEMBER        => 'impro-team-member',
				\Impro\Team\Member\Role::ID_MANAGER       => 'impro-team-member-manager',
				\Impro\Team\Member\Role::ID_TRAINER       => 'impro-team-member-trainer',
				\Impro\Team\Member\Role::ID_FINANCIAL     => 'impro-team-member-financial',
				\Impro\Team\Member\Role::ID_PLAYER        => 'impro-team-member-player',
				\Impro\Team\Member\Role::ID_OCCASIONALIST => 'impro-team-member-player-occasional',
				\Impro\Team\Member\Role::ID_MUSICIAN      => 'impro-team-member-musician',
				\Impro\Team\Member\Role::ID_FAN           => 'impro-team-member-fan',
			)),
			"active" => array("bool"),
			"attd"   => array('has_many', "model" => 'Impro\Team\Training\Ack'),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true,
			'view' => true,
		);


		public function get_name($pattern = null)
		{
			return $this->user->get_name($pattern);
		}


		public function get_roles(\System\Template\Renderer $ren)
		{
			$roles = array();
			foreach ($this->roles as $role) {
				$roles[] = $ren->trans(\Impro\Team\Member\Role::get_name($role));
			}

			return $roles;
		}


		public function to_html(\System\Template\Renderer $ren)
		{
			return div('team_member', array(
				$ren->link_for('team', $this->team->logo->to_html($ren, 56, 38), args($this->team)),
				div('team_member_info', array(
					$this->team->to_html_link($ren),
					div('roles', implode(', ', $this->get_roles($ren))),
				)),
				div('cleaner', ''),
			));
		}


		public function to_html_member(\System\Template\Renderer $ren)
		{
			return div('team_user', array(
				\Impro\User::avatar($ren, $this->user, 50, 50),
				div('team_member_info', array(
					div('name', array(
						\Impro\User::link($ren, $this->user),
					)),
					div('roles', implode(', ', $this->get_roles($ren))),
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
