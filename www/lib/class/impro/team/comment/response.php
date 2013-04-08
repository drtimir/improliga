<?


namespace Impro\Team\Comment
{
	class Response extends \System\Model\Database
	{
		protected static $attrs = array(
			"text"    => array('text'),
			"visible" => array('bool', "default" => false),
		);


		protected static $belongs_to = array(
			"comment" => array("model" => '\Impro\Team'),
			"user"    => array("model" => '\System\User', "is_null" => true),
		);
	}
}
