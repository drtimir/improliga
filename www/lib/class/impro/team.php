<?

namespace Impro
{
	class Team extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"       => array("varchar"),
			"name_full"  => array("varchar"),
			"city"       => array("varchar", "default" => ''),
			"about"      => array("text", "default" => ''),
			"logo"       => array('image', "default" => "/share/pixmaps/logo_original.png"),
			"photo"      => array('image', "default" => "/share/pixmaps/impro/team.png"),
			"mail"       => array("varchar", "default" => ''),
			"site"       => array("varchar", "default" => ''),
			"played"     => array("int", "is_unsigned" => true, "default" => 0),
			"visible"    => array("bool"),
		);

		protected static $belongs_to = array(
			"author" => array("model" => "\System\User"),
			"hq"     => array("model" => "\System\Location"),
		);

		protected static $has_many = array(
			"members"   => array("model" => "\Impro\Team\Member"),
			"galleries" => array("model" => '\Impro\Gallery', "is_bilinear" => true),
			"comments"  => array("model" => '\Impro\Team\Comment', "foreign_name" => 'id_team'),
		);


		public function count_members()
		{
			return $this->members->count();
		}


		public function to_html_link(\System\Template\Renderer $ren, $short_name = true)
		{
			if ($short_name && mb_strlen($this->name_full) > 32) {
				$long_name = substr($this->name_full, 0, 32) . '...';
			} else {
				$long_name = $this->name_full;
			}

			return div('name', array(
				$ren->link_for('team', $this->name, array("args" => array($this), "class" => 'short')),
				span('sep', ' - '),
				$ren->link_for('team', $long_name, array("args" => array($this), "class" => 'full')),
			));
		}


		public function label(\System\Template\Renderer $ren)
		{
			return $ren->link_for(
				'team',
				\Stag::span(array(
					"class" => "icon",
					"style" => "background:url(".$this->logo->thumb_trans(16, 16).'); width:16px; height:16px;',
					"close" => true,
				))
					.span('team_name_short', $this->name),
				array("args" => array($this))
			);
		}


		public function get_leaders()
		{
			$members = $this->members->fetch();
			$roles   = \Impro\Team\Member\Role::get_manager_roles();
			$people  = array();

			foreach ($members as $member) {
				foreach ($member->roles as $role) {
					if (in_array($role, $roles)) {
						$people[] = $member;
						break;
					}
				}
			}

			return $people;
		}


		/** Get current user member object if user is a member
		 * @return false|Impro\Team\Member
		 */
		public function member(\System\User $user)
		{
			foreach ($user->members as $member) {
				if ($member->id_impro_team == $this->id) {
					return $member;
				}
			}

			return false;
		}


		public function can_user(\System\User $user, $perm_id)
		{
			if ($mem = $this->member($user)) {
				return $mem->has_right($perm_id);
			}

			return false;
		}
	}
}
