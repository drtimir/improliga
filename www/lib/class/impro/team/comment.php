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


		public function to_html($link_respond)
		{
			return div('post', array(
				div('avatar', $this->user ?
					\Impro\User::avatar($this->user, 50, 50):
					\System\User::guest()->image->to_html(50,50)
				),
				div('content', array(
					div('name', $this->user ? \Impro\User::link($this->user):l('anonymous')),
					div('text', \System\Template::to_html($this->text)),
					div('footer', array(
						link_for(format_date($this->created_at, 'human'), soprintf($link_respond, $this), array("class" => 'item date')),
						link_for($this->responses_count ? t('impro_team_comment_response_count', $this->responses_count):l('impro_team_comment_respond'), soprintf($link_respond, $this), array("class" => 'item link_responses')),
					)),
				)),
				span('cleaner', ''),
			));
		}


		public function get_responses()
		{
			return $this->responses->where(array("visible" => true))->sort_by('created_at desc');
		}
	}
}
