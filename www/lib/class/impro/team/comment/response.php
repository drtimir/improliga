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
					div('text', to_html($this->text)),
					div('footer', array(
						$ren->link_for('team_comment_respond', format_date($this->created_at, 'human'), array("args" => array($this->comment->team, $this->comment), "class" => 'item date')),
					)),
				)),
				span('cleaner', ''),
			));
		}
	}
}
