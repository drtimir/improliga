<?


namespace Impro\Team\Comment
{
	class Response extends \Impro\Team\Comment
	{
		protected static $attrs = array(
			"text"    => array('text'),
			"visible" => array('bool', "default" => false),
		);


		protected static $belongs_to = array(
			"comment" => array("model" => '\Impro\Team\Comment'),
			"user"    => array("model" => '\System\User', "is_null" => true),
		);


		public function to_html(\System\Template\Renderer $ren)
		{
			return div('post', array(
				div('avatar', $this->user ?
					\Impro\User::avatar($ren, $this->user, 50, 50):
					\System\User::guest()->image->to_html(50,50)
				),
				div('content', array(
					div('name', $this->user ? \Impro\User::link($ren, $this->user):l('anonymous')),
					div('text', to_html($ren, $this->text)),
					div('footer', array(
						$ren->link_for('team_comment_respond', $ren->format_date($this->created_at, 'human'), array("args" => array($this->comment->team, $this->comment), "class" => 'item date')),
					)),
				)),
				span('cleaner', ''),
			));
		}


		public function mail(\System\Template\Renderer $ren)
		{
			$users = get_all('\Impro\Team\Comment\Response')
				->where(array("id_comment" => $this->id_comment, "id_user != ".intval($this->comment->id_user).""))
				->join('system_user', 'ON (t1.id_system_user = t0.id_user)', 't1')
				->add_cols(array('id_system_user', 'login'), 't1')
				->group_by('t1.id_system_user')
				->assoc_with('\System\User')
				->fetch();

			$noticed_owner = false;

			foreach ($users as $user) {
				if ($user->id !== $this->id_user) {
					$notice = \Impro\User\Notice::for_user($user, array(
						"id_user"   => $user->id,
						"id_author" => $this->id_user,
						"redirect"  => $ren->uri('team_comment_respond', array($this->comment->team, $this->comment)).'#post_'.$this->id,
						"text"      => stprintf($ren->trans('intra_team_comment_response'), array(
							"text"      => to_html($this->text),
							"user_name" => \Impro\User::link($ren, $this->user),
							"team_name" => $this->comment->team->to_html_link($ren),
						)),
					))->mail($ren->locales());
				}
			}

			if (!$noticed_owner && $this->id_user != $this->comment->id_user) {
				$notice = \Impro\User\Notice::for_user($user, array(
					"id_user"   => $user->id,
					"id_author" => $this->id_user,
					"redirect"  => $ren->uri('team_comment_respond', array($this->comment->team, $this->comment)).'#post_'.$this->id,
					"text"      => stprintf($ren->trans('intra_team_comment_response_owner'), array(
						"text"      => to_html($this->text),
						"user_name" => \Impro\User::link($ren, $this->user),
						"team_name" => $this->comment->team->to_html_link($ren),
					)),
				))->mail($ren->locales());
			}
		}
	}
}
