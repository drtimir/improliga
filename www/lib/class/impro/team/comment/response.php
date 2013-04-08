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
			"comment" => array("model" => '\Impro\Team'),
			"user"    => array("model" => '\System\User', "is_null" => true),
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
					)),
				)),
				span('cleaner', ''),
			));
		}
	}
}
