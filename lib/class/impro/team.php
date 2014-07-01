<?

namespace Impro
{
	class Team extends \System\Model\Perm
	{
		protected static $attrs = array(
			"name"           => array('varchar'),
			"name_full"      => array('varchar'),
			"city"           => array('varchar', "default" => ''),
			"hq"             => array('belongs_to', "model" => 'System\Location', "is_null" => true),
			"loc_trainings"  => array('belongs_to', "model" => 'System\Location', "is_null" => true),
			"about"          => array('text', "default" => ''),
			"logo"           => array('image', "default" => "/share/pixmaps/logo_original.png"),
			"photo"          => array('image', "default" => "/share/pixmaps/impro/team.png"),
			"mail"           => array('varchar', "default" => ''),
			"site"           => array('varchar', "default" => ''),

			"visible"        => array('bool'),
			"published"      => array('bool'),
			"dissolved"      => array('bool'),

			"author"         => array('belongs_to', "model" => "System\User"),
			"members"        => array('has_many', "model" => "Impro\Team\Member"),

			"accepting"      => array('bool'),
			"use_discussion" => array('bool'),
			"use_attendance" => array('bool'),
			"use_booking"    => array('bool'),

			"topics"    => array('has_many', "model" => "Impro\Team\Discussion\Topic"),
			"comments"  => array('has_many', "model" => 'Impro\Team\Comment', "foreign_name" => 'id_team'),
			"posts"     => array('has_many', "model" => 'Impro\Post'),
			"trainings" => array('has_many', "model" => 'Impro\Team\Training'),
		);


		protected static $access = array(
			'schema' => true,
			'browse' => true
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
					"style" => "background:url(".$this->logo->thumb(16, 16).'); width:16px; height:16px;',
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


		public function send_request(\System\User $user, \System\Template\Renderer $ren, \System\Http\Request $request)
		{
			return \Impro\User\Request::for_user($user, array(
				"text"         => stprintf($ren->locales()->trans('intra_team_member_add_text'), array(
					"link_team" => $this->to_html_link($ren),
					"link_user" => \Impro\User::link($ren, $request->user()),
				)),
				"id_author"    => $request->user()->id,
				"id_team"      => $this->id,
				"callback"     => 'JoinTeam',
				"redirect_yes" => $ren->uri('team', array($this)),
				"allow_maybe"  => false,
			))->mail($ren);
		}


		public function mail_to(\System\Template\Renderer $ren, array $opts)
		{
			$leaders = $this->get_leaders();
			$rcpt = array();

			foreach ($leaders as $leader) {
				$opts["id_user"] = $leader->id_user;
				$notice = \Impro\User\Notice::for_user($leader->user, $opts);
				$notice->mail($ren->locales());
			}

			return $this;
		}


		public static function filter_search($query, $value)
		{
			if ($value) {
				$value = \System\Database::get_db()->escape_string($value);
				$query->where(array(
					array(
						"city LIKE '%".$value."%'",
						"name LIKE '%".$value."%'",
					)
				));
			}
		}
	}
}
