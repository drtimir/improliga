<?


namespace Impro\Team
{
	class Comment extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"    => array('text'),
			"visible" => array('bool', "default" => false),
		);


		protected static $belongs_to = array(
			"team" => array("model" => '\Impro\Team'),
			"user" => array("model" => '\System\User', "is_null" => true),
		);


		protected static $has_many = array(
			"responses" => array("model" => '\Impro\Team\Comment\Response', "foreign_name" => 'id_comment'),
		);


		public function to_html(\System\Template\Renderer $ren)
		{
			$url_respond = $ren->url('team_comment_respond', array($this->team, $this));

			return div('post', array(
				div('avatar', $this->user ?
					\Impro\User::avatar($ren, $this->user, 50, 50):
					\System\User::guest()->image->to_html(50,50)
				),
				div('content', array(
					div('name', $this->user ? \Impro\User::link($ren, $this->user):l('anonymous')),
					div('text', \System\Template::to_html($this->text)),
					div('footer', array(
						$ren->link($url_respond, format_date($this->created_at, 'human'), array("class" => 'item date')),
						$ren->link($url_respond, $this->responses_count ? t('impro_team_comment_response_count', $this->responses_count):l('impro_team_comment_respond'), array("class" => 'item link_responses')),
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
					"id_author" => $this->id_user,
					"redirect"  => $ren->uri('team_comment_respond', array($this->team, $this)),
					"text"      => stprintf(l('intra_team_comment_new'), array(
						"text"      => to_html($this->text),
						"user_name" => \Impro\User::link($ren, $this->user),
						"team_name" => $this->team->to_html_link($ren),
					)),
				));

				$notice->mail();
			}

			return $this;
		}
	}
}
