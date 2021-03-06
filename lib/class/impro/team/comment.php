<?


namespace Impro\Team
{
	class Comment extends \System\Model\Perm
	{
		protected static $attrs = array(
			"team"      => array('belongs_to', "model" => 'Impro\Team'),
			"author"    => array('belongs_to', "model" => 'System\User', "is_null" => true),
			"text"      => array('text'),
			"visible"   => array('bool', "default" => false),
			"responses" => array('has_many', "model" => 'Impro\Team\Comment\Response', "foreign_name" => 'id_comment'),
		);


		public function render(\System\Template\Renderer $ren)
		{
			$url_respond = $ren->url('team_comment_respond', array($this->team, $this));

			return div('post', array(
				div('avatar', $this->author ?
					\Impro\User::avatar($ren, $this->author, 50, 50):
					\System\User::guest()->image->to_html($ren, 50,50)
				),
				div('content', array(
					div('name', $this->author ? \Impro\User::link($ren, $this->author):$ren->trans('anonymous')),
					div('text', to_html($ren, $this->text)),
					div('footer', array(
						$ren->link($url_respond, $ren->format_date($this->created_at, 'human'), array("class" => 'item date')),
						$ren->link($url_respond, $this->responses_count ? $ren->trans('impro_team_comment_response_count', $this->responses_count):$ren->trans('impro_team_comment_respond'), array("class" => 'item link_responses')),
					)),
				)),
				span('cleaner', ''),
			));
		}


		public function get_responses()
		{
			return $this->responses->where(array("visible" => true))->sort_by('created_at desc');
		}


		public function mail(\System\Template\Renderer $ren)
		{
			$leaders = $this->team->get_leaders();
			$rcpt = array();

			foreach ($leaders as $leader) {
				$notice = \Impro\User\Notice::for_user($leader->user, array(
					"id_user"   => $leader->id_user,
					"id_author" => $this->id_author,
					"redirect"  => $ren->uri('team_comment_respond', array($this->team, $this)),
					"text"      => stprintf($ren->trans('intra_team_comment_new_text'), array(
						"text"      => to_html($ren, $this->text),
						"user_name" => \Impro\User::link($ren, $this->author),
						"team_name" => $this->team->to_html_link($ren),
					)),
				));

				$notice->mail($ren->locales());
			}

			return $this;
		}
	}
}
